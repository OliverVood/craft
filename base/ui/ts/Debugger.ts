namespace Base {

	export type DebuggerData						= { network: DebuggerDataNetwork, post: DebuggerVariable, get: DebuggerVariable, files: DebuggerVariable, variables: DebuggerVariables, queries: DebuggerDBHistory, controllers: DebuggerController, models: DebuggerModels, timestamps: DebuggerTimestamps, user: DebuggerUser };

	type DebuggerDataNetwork						= { method: string, method_virtual: string, url: string, ip: string };
	type DebuggerVariables							= { title: string, var: DebuggerVariable };
	type DebuggerDBHistory							= DebuggerDBRecord[];
	type DebuggerController							= string[];
	type DebuggerModels								= string[];
	type DebuggerTimestamps							= Record<string, DebuggerTimestamp>;
	type DebuggerUser								= { id: number, alias: string };

	type DebuggerVariable							= DebuggerVariableBoolean | DebuggerVariableInteger | DebuggerVariableDouble | DebuggerVariableString | DebuggerVariableNull | DebuggerVariableArray | DebuggerVariableObject;

	type DebuggerVariableBoolean					= { type: 'boolean', value: string };
	type DebuggerVariableInteger					= { type: 'integer', value: number };
	type DebuggerVariableDouble						= { type: 'double', value: number };
	type DebuggerVariableString						= { type: 'string', value: string };
	type DebuggerVariableNull						= { type: 'null', value: null };
	type DebuggerVariableArray						= { type: 'array', value: DebuggerVariableArrayContent[] };
	type DebuggerVariableObject						= { type: 'object', value: DebuggerVariableObjectContent };

	type DebuggerVariableArrayContent				= { key: DebuggerVariableArrayKey, value: DebuggerVariable };
	type DebuggerVariableArrayKey					= { type: 'integer', value: number } | { type: 'double', value: number } | { type: 'string', value: string };

	type DebuggerVariableObjectContent				= { namespace: string, name: string, modifiers: DebuggerVariableObjectModifier[], constants: DebuggerVariableObjectConstant[], properties: DebuggerVariableObjectProperty[], methods: DebuggerVariableObjectMethod[] };
	type DebuggerVariableObjectConstant				= { modifiers: DebuggerVariableObjectConstantsModifier[], name: string, value: DebuggerVariable };
	type DebuggerVariableObjectProperty				= { modifiers: DebuggerVariableObjectPropertiesModifier[], name: string, value: DebuggerVariable };
	type DebuggerVariableObjectMethod				= { modifiers: DebuggerVariableObjectMethodsModifier[], name: string };

	type DebuggerVariableObjectModifier				= 'abstract' | 'implicit' | 'explicit' | 'final' | 'readonly';
	type DebuggerVariableObjectConstantsModifier	= 'public' | 'protected' | 'private' | 'final';
	type DebuggerVariableObjectPropertiesModifier	= 'public' | 'protected' | 'private' | 'static' | 'readonly';
	type DebuggerVariableObjectMethodsModifier		= 'public' | 'protected' | 'private' | 'final' | 'static' | 'abstract';

	type DebuggerDBRecord							= { db: string, query: string, time: number };

	type DebuggerTimestamp							= { name: string, start: number, stop: number | null, duration: number | null, stamps: DebuggerTimestampStamp[] };
	type DebuggerTimestampStamp						= { name: string, time: number, duration: number | null };

	/**
	 * Отладчик
	 */
	export class Debugger {
		private readonly STORAGE_DEBUGGER_OPEN = 'debugger_open';
		private readonly STORAGE_DEBUGGER_OPEN_SPACE = 'debugger_open_space';
		private readonly STORAGE_DEBUGGER_RECORD = 'debugger_record';
		private readonly STORAGE_DEBUGGER_TRACK = 'debugger_track';
		private readonly STORAGE_DEBUGGER_HEIGHT = 'debugger_height';
		private readonly STORAGE_DEBUGGER_HEIGHT_DEFAULT = 200;

		private readonly STATE_OPEN = '1';
		private readonly STATE_CLOSE = '0';

		private readonly STATE_ACTIVE = '1';
		private readonly STATE_INACTIVE = '0';

		private static instance: Debugger;

		private open				: boolean;
		private record				: boolean;
		private track				: boolean;
		private spaceActive			: string;
		private count				: number;
		private data				: Record<number, DebuggerData>;

		private $document			: UIElement;
		private $container			: UIElement;
		private $manager			: UIElement;
		private readonly $toggle	: UIElement;
		private $setting			: UIElement;
		private $work				: UIElement;
		private readonly $record	: UIElement;
		private readonly $track		: UIElement;
		private readonly $clear		: UIElement;
		private readonly $drag		: UIElement;
		private readonly $spaces	: UIElement;
		private $panel				: UIElement;
		private $buttons			: Record<string, UIElement>;

		private spaces				: Record<string, Space>;

		private constructor() {
			this.open				= localStorage.getItem(this.STORAGE_DEBUGGER_OPEN) == this.STATE_OPEN;
			this.record				= localStorage.getItem(this.STORAGE_DEBUGGER_RECORD) === null || localStorage.getItem(this.STORAGE_DEBUGGER_RECORD) == this.STATE_ACTIVE;
			this.track				= localStorage.getItem(this.STORAGE_DEBUGGER_TRACK) === null || localStorage.getItem(this.STORAGE_DEBUGGER_TRACK) == this.STATE_ACTIVE;

			this.spaceActive		= '';
			this.count				= 0;
			this.data				= {};

			this.$document			= el(document.body);
			this.$container			= el('div', {class: 'debugger'});
			this.$manager			= el('div', {class: 'manager'});
			this.$toggle			= el('div', {class: 'toggle'});
			this.$setting			= el('div', {class: 'setting'});
			this.$work				= el('div', {class: 'work'});
			this.$record			= el('a', {class: 'record'});
			this.$track				= el('a', {class: 'track'});
			this.$clear				= el('a', {class: 'clear'});
			this.$drag				= el('div', {class: 'drag'});
			this.$spaces			= el('div', {class: 'spaces'});
			this.$panel				= el('div', {class: 'panel'});
			this.$buttons = {
				network				: el('a').text(__('Сеть')),
				get					: el('a').text(__('GET')),
				post				: el('a').text(__('POST')),
				files				: el('a').text(__('FILES')),
				variables			: el('a').text(__('Переменные')),
				queries				: el('a').text(__('Запросы')),
				controllers			: el('a').text(__('Контроллеры')),
				models				: el('a').text(__('Модели')),
				timestamps			: el('a').text(__('Отметки времени')),
				user				: el('a').text(__('Пользователь')),
			};

			this.$document.append(
				this.$container.append(
					this.$manager.append(
						this.$toggle,
						this.$setting.append(
							this.$record,
							this.$track,
							this.$clear
						)
					),
					this.$work.append(
						this.$drag,
						this.$spaces,
						this.$panel.append(
							this.$buttons.network,
							this.$buttons.get,
							this.$buttons.post,
							this.$buttons.files,
							this.$buttons.variables,
							this.$buttons.queries,
							this.$buttons.controllers,
							this.$buttons.models,
							this.$buttons.timestamps,
							this.$buttons.user
						)
					)
				)
			);

			this.spaces= {
				network: new SpaceNetwork(this.$spaces),
				get: new SpaceVariables(this.$spaces),
				post: new SpaceVariables(this.$spaces),
				files: new SpaceVariables(this.$spaces),
				variables: new SpaceVariables(this.$spaces),
				queries: new SpaceDBHistory(this.$spaces),
				controllers: new SpaceControllers(this.$spaces),
				models: new SpaceModels(this.$spaces),
				timestamps: new SpaceTimestamps(this.$spaces),
				user: new SpaceUser(this.$spaces)
			};

			this.$toggle.on('click', () => this.toggleWorkSpace(!this.open));
			this.$record.on('click', () => this.toggleRecord(!this.record));
			this.$track.on('click', () => this.toggleTrack(!this.track));
			this.$clear.on('click', () => this.clearAll());
			this.$drag.on('pointerdown', event => this.pointerDown(event as PointerEvent));

			this.$buttons.network.on('click', () => this.spaceOpen('network'));
			this.$buttons.get.on('click', () => this.spaceOpen('get'));
			this.$buttons.post.on('click', () => this.spaceOpen('post'));
			this.$buttons.files.on('click', () => this.spaceOpen('files'));
			this.$buttons.variables.on('click', () => this.spaceOpen('variables'));
			this.$buttons.queries.on('click', () => this.spaceOpen('queries'));
			this.$buttons.controllers.on('click', () => this.spaceOpen('controllers'));
			this.$buttons.models.on('click', () => this.spaceOpen('models'));
			this.$buttons.user.on('click', () => this.spaceOpen('user'));
			this.$buttons.timestamps.on('click', () => this.spaceOpen('timestamps'));

			this.redraw();
		}

		/**
		 * Возвращает экземпляр отладчика
		 */
		public static getInstance(): Debugger {
			if (!this.instance) this.instance = new Debugger();

			return this.instance;
		}

		/**
		 * Добавляет запись в отладчик
		 * @param data - Данные
		 */
		public append(data: DebuggerData): void {
			if (!this.record) return;

			this.count++;

			this.data[this.count] = data;
			this.spaces['network'].setData(data['network'], this.count);
			if (this.track) this.load(this.count);
		}

		/**
		 * Загрузка данных
		 * @param iteration - Номер записи
		 */
		public load(iteration: number): void {
			(this.spaces['network'] as SpaceNetwork).setActive(iteration);

			this.spaces['get'].clear().setData([{title: 'GET', var: this.data[iteration]['get']}], iteration);
			this.spaces['post'].clear().setData([{title: 'POST', var: this.data[iteration]['post']}], iteration);
			this.spaces['files'].clear().setData([{title: 'FILES', var: this.data[iteration]['files']}], iteration);
			this.spaces['variables'].clear().setData(this.data[iteration]['variables'], iteration);
			this.spaces['queries'].clear().setData(this.data[iteration]['queries']);
			this.spaces['controllers'].clear().setData(this.data[iteration]['controllers']);
			this.spaces['models'].clear().setData(this.data[iteration]['models']);
			this.spaces['timestamps'].clear().setData(this.data[iteration]['timestamps']);
			this.spaces['user'].clear().setData(this.data[iteration]['user']);
		}

		/**
		 * Перерисовка интерфейса отладчика
		 * @private
		 */
		private redraw(): void {
			this.toggleWorkSpace(this.open);
			this.toggleRecord(this.record);
			this.toggleTrack(this.track);

			this.spaceOpen(localStorage.getItem(this.STORAGE_DEBUGGER_OPEN_SPACE) || 'network');

			let debug_height = localStorage.getItem(this.STORAGE_DEBUGGER_HEIGHT);
			this.$spaces.style({height: `${ debug_height || this.STORAGE_DEBUGGER_HEIGHT_DEFAULT }px`});
		}

		/**
		 * Показывает/скрывает рабочее пространство отладчика
		 * @param open - Открыть/закрыть
		 * @private
		 */
 		private toggleWorkSpace(open: boolean): void {
			this.open = open;

			if (this.open) {
				localStorage.setItem(this.STORAGE_DEBUGGER_OPEN, this.STATE_OPEN);
				this.$work.removeClass('hide')
			} else {
				localStorage.setItem(this.STORAGE_DEBUGGER_OPEN, this.STATE_CLOSE);
				this.$work.addClass('hide');
			}
		}

		/**
		 * Включает/выключает отслеживание запросов
		 * @param active - Включить/выключить
		 * @private
		 */
		private toggleRecord(active: boolean): void {
			this.record = active;

			if (this.record) {
				localStorage.setItem(this.STORAGE_DEBUGGER_RECORD, this.STATE_ACTIVE);
				this.$record.addClass('active')
			} else {
				localStorage.setItem(this.STORAGE_DEBUGGER_RECORD, this.STATE_INACTIVE);
				this.$record.removeClass('active');
			}
		}

		/**
		 * Включает/выключает автоматическое переключение на последний запрос
		 * @param active - Включить/выключить
		 * @private
		 */
		private toggleTrack(active: boolean): void {
			this.track = active;

			if (this.track) {
				localStorage.setItem(this.STORAGE_DEBUGGER_TRACK, this.STATE_ACTIVE);
				this.$track.addClass('active')
			} else {
				localStorage.setItem(this.STORAGE_DEBUGGER_TRACK, this.STATE_INACTIVE);
				this.$track.removeClass('active');
			}
		}

		/**
		 * Открывает рабочее пространство
		 * @param name - Наименование пространства
		 * @private
		 */
		private spaceOpen(name: string): void {
			if (name === this.spaceActive) return;

			if (this.spaceActive) {
				this.$buttons[this.spaceActive].removeClass('active');
				this.spaces[this.spaceActive].hide();
			}

			this.$buttons[name].addClass('active');
			this.spaces[name].show();

			this.spaceActive = name;
			localStorage.setItem(this.STORAGE_DEBUGGER_OPEN_SPACE, name);
		}

		/**
		 * Очищает отладчик от данных
		 * @private
		 */
		private clearAll() {
			this.spaces['network'].clear();
			this.spaces['post'].clear();
			this.spaces['get'].clear();
			this.spaces['files'].clear();
			this.spaces['variables'].clear();
			this.spaces['queries'].clear();
			this.spaces['controllers'].clear();
			this.spaces['models'].clear();
			this.spaces['timestamps'].clear();
			this.spaces['user'].clear();

			this.data = {};
			this.count = 0;
		}

		/**
		 * Обработчик изменения размеров окна отладчика
		 * @param event - Событие
		 * @private
		 */
		private pointerDown(event: PointerEvent) {
			this.$drag.setPointerCapture(event.pointerId);

			let maxHeight = 500;
			let minHeight = 100;
			let clientYDown = event.clientY;
			let heightDown = this.$spaces.html().offsetHeight;

			/**
			 * Обработчик перемещения указателя
			 * @param event - Событие
			 */
			let move = (event: Event): void => {
				let currentEvent = event as PointerEvent;
				let alpha = clientYDown - currentEvent.clientY;
				let height = heightDown + alpha;

				if (height < minHeight) height = minHeight;
				if (height > maxHeight) height = maxHeight;

				this.$spaces.style({height: `${height}px`});
			};

			/**
			 * Обработчик окончания перемещения указателя
			 */
			let up = (): void => {
				localStorage.setItem(this.STORAGE_DEBUGGER_HEIGHT, parseInt(this.$spaces.getStyle('height')).toString());

				this.$drag.off('pointermove', move);
				this.$drag.off('pointerup', up);
			};

			this.$drag.on('pointermove', move);
			this.$drag.on('pointerup', up);
		}

	}

	/**
	 * Базовый класс пространств отладчика
	 */
	abstract class Space {
		private readonly open		: boolean;

		protected $space			: UIElement;

		protected constructor($spaces: UIElement) {
			this.open				= false;

			this.$space				= el('div');

			this.redraw();

			$spaces.append(this.$space);
		}

		/**
		 * Подготовка данных
		 * @param data - Данны
		 * @protected
		 */
		protected prepareData(data: any): any { return data; }

		/**
		 * Установка данных
		 * @param data - Данные
		 * @param iteration - Номер записи
		 */
		abstract setData(data: any, iteration?: number): void;

		/**
		 * Очистка пространства от данных
		 */
		abstract clear(): Space;

		/**
		 * Скрывает пространство
		 */
		public hide(): void { this.$space.addClass('hide'); }

		/**
		 * Показывает пространство
		 */
		public show(): void { this.$space.removeClass('hide'); }

		/**
		 * Перерисовка
		 * @private
		 */
		private redraw(): void {
			this.open ? this.show() : this.hide();
		}

	}

	/**
	 * Базовый класс пространств отладчика представленных в виде таблиц
	 */
	abstract class SpaceTable extends Space {
		protected columns			: Record<string, string>;

		protected $wrap				: UIElement;
		private readonly $head		: UIElement;

		protected constructor($spaces: UIElement, columns: Record<string, string>) {
			super($spaces);

			this.columns			= columns;

			this.$wrap				= el('div', {class: 'table'});
			this.$head				= el('div', {class: 'head'});

			this.$space.append(
				this.$wrap.append(
					this.$head
				)
			);

			for (const i in this.columns) this.$head.append(
				this.getColumn(this.columns[i])
			);
		}

		/**
		 * Возвращает элемент заголовка колонки
		 * @param text - Текст
		 * @protected
		 */
		protected getColumn(text: string): UIElement {
			let $item	= el('div');

			$item.text(text);

			return $item;
		}

		/**
		 * Установка данных
		 * @param data - Данные
		 * @param iteration - Номер записи
		 */
		public setData(data: any, iteration?: number): void {
			let prepareData = this.prepareData(data);

			for (const i in prepareData) {
				let $row	= el('div', {class: 'line'});

				for (const column in this.columns) $row.append(
					this.getColumn(prepareData[i][column])
				);

				this.$wrap.append($row);
			}
		}

		/**
		 * Очистка пространства
		 */
		public clear(): Space {
			let elements = this.$wrap.find('.line');

			for (let i = 0; i < elements.length; i++) {
				(elements[i] as HTMLElement).remove();
			}

			return this;
		}

	}

	/**
	 * Пространство интернет запросов
	 */
	class SpaceNetwork extends SpaceTable {
		private dataActive			: number;

		public constructor($spaces: UIElement) {
			super($spaces, {'method': __('Метод'), 'method_virtual': __('Виртуальный метод'), 'url': __('URL'), 'ip': __('IP')});

			this.dataActive			= 0;
		}

		/**
		 * Установка данных
		 * @param data - Данные
		 * @param iteration - Номер записи
		 */
		public setData(data: DebuggerDataNetwork, iteration: number): void {
			let $row	= el('div', {class: 'line link'});

			for (const column in this.columns) $row.append(
				this.getColumn(data[column as keyof DebuggerDataNetwork])
			);

			this.$wrap.append($row);

			$row.on('click', () => { Debugger.getInstance().load(iteration); });
		}

		public clear(): Space {
			super.clear();

			this.dataActive = 0;

			return this;
		}

		/**
		 * Задаёт активную строку
		 * @param iteration - Номер записи
		 */
		public setActive(iteration: number): void {
			let $rows	= this.$wrap.find('.line.link');

			if (this.dataActive) ($rows[this.dataActive - 1] as HTMLElement).classList.remove('active');
			($rows[iteration - 1] as HTMLElement).classList.add('active');

			this.dataActive = iteration;
		}

	}

	/**
	 * Пространство вызова контроллеров
	 */
	class SpaceControllers extends SpaceTable {
		public constructor($spaces: UIElement) {
			super($spaces, {'call': __('Вызов')});
		}

		/**
		 * Подготовка данных
		 * @param data - Данны
		 * @protected
		 */
		protected prepareData(data: DebuggerDBHistory): any {
			let out = [];
			for (const i in data) out.push({ call: data[i] });

			return out;
		}

	}
	/**
	 * Пространство инициализации моделей
	 */
	class SpaceModels extends SpaceTable {

		public constructor($spaces: UIElement) {
			super($spaces, {'name': __('Имя')});
		}

		/**
		 * Подготовка данных
		 * @param data - Данны
		 * @protected
		 */
		protected prepareData(data: DebuggerModels): any {
			let out = [];
			for (const i in data) out.push({ name: data[i] });

			return out;
		}

	}

	/**
	 * Пространство запросов базу данных
	 */
	class SpaceDBHistory extends SpaceTable {
		public constructor($spaces: UIElement) {
			super($spaces, {'number': __('№'), 'time': __('Время'), 'db': __('БД'), 'query': __('Запрос')});
		}

		/**
		 * Подготовка данных
		 * @param data - Данны
		 * @protected
		 */
		protected prepareData(data: DebuggerDBHistory): any {
			let out = [];
			for (const i in data) out.push({ number: Number(i) + 1, time: data[i]['time'], db: data[i]['db'], query: data[i]['query'] });

			return out;
		}

	}

	/**
	 * Пространство отметок времени
	 */
	class SpaceTimestamps extends SpaceTable {
		public constructor($spaces: UIElement) {
			super($spaces, {
				name: __('Имя'),
				action: __('Действие'),
				time: __('Время'),
				duration: __('Продолжительность')
			});
		}

		/**
		 * Подготовка данных
		 * @param data - Данны
		 * @protected
		 */
		protected prepareData(data: DebuggerTimestamps): any {
			let out = [];
			for (const i in data) {
				out.push({
					name: data[i]['name'],
					action: __('Запуск'),
					time: data[i]['start'],
					duration: 0
				});

				for (const j in data[i]['stamps']) {
					out.push({
						name: data[i]['stamps'][j]['name'] || '',
						action: __('Метка'),
						time: data[i]['stamps'][j]['time'],
						duration: data[i]['stamps'][j]['duration'] || 0
					});
				}

				out.push({
					name: data[i]['name'],
					action: __('Остановка'),
					time: data[i]['stop'],
					duration: data[i]['duration'] || 0
				});
			}

			return out;
		}

	}

	/**
	 * Пространство пользователя
	 */
	class SpaceUser extends SpaceTable {
		public constructor($spaces: UIElement) {
			super($spaces, {'param': __('Параметр'), 'value': __('Значение')});
		}

		/**
		 * Подготовка данных
		 * @param data - Данны
		 * @protected
		 */
		protected prepareData(data: DebuggerUser): any {
			return [
				{'param': __('Идентификатор'), 'value': data['id']},
				{'param': __('Псевдоним'), 'value': data['alias']}
			];
		}

	}

	/**
	 * Пространство переменных
	 */
	class SpaceVariables extends Space {
		public constructor($spaces: UIElement) {
			super($spaces);
		}

		/**
		 * Установка данных
		 * @param data - Данные
		 * @param iteration - Номер записи
		 */
		public setData(data: DebuggerVariables[], iteration?: number): void {
			for (const datum of data) {
				let $dump				= el('div', {class: 'dump'});
				let $title				= el('div', {class: 'title'});
				let $content				= el('div', {class: 'content'});

				this.$space.append(
					$dump.append(
						$title,
						$content
					)
				);

				$title.text(datum['title']);
				$content.append(this.getVariable(datum['var']));
			}
		}

		/**
		 * Очистка пространства
		 */
		public clear(): Space {
			this.$space.text('');

			return this;
		}

		/**
		 * Возвращает элемент с информацией о переменной
		 * @param data - Данные
		 */
		public getVariable(data: DebuggerVariable): UIElement {
			let $var						= el('div', {class: `variable ${data['type']}`});
			let $type					= el('div', {class: 'type'});
			let $value					= el('div', {class: 'value'});

			$var.append(
				$type,
				$value
			);

			$type.text(data['type']);

			switch (data['type']) {
				case 'boolean': $value.text(data['value'].toString()); break;
				case 'integer': case 'double': $value.text(data['value'].toString()); break;
				case 'string': $value.text(data['value']); break;
				case 'null': $value.text('null'); break;
				case 'array': $value.append(this.getArray(data['value'])); break;
				case 'object': $value.append(this.getObject(data['value'])); break;
			}

			return $var;
		}

		/**
		 * Возвращает элементы с информацией о массиве
		 * @param elems - Данные
		 */
		private getArray(elems: DebuggerVariableArrayContent[]): UIElement[] {
			let $more					= el('div', {class: 'more'});
			let $elems					= el('div', {class: 'elems'});

			for (const elem of elems) {
				let $elem				= el('div');
				let $key					= el('div', {class: 'key'});
				let $index				= el('span');
				let $value				= el('div', {class: 'value'});

				if (elem['key']['type'] == 'string') {
					$key.addClass('string');
					$index.text(`'${elem['key']['value']}'`);
				} else {
					$key.addClass('number');
					$index.text(elem['key']['value'].toString());
				}
				$key.append('[ ', $index , ' ]');

				$elems.append(
					$elem.append(
						$key,
						$value.append(
							this.getVariable(elem['value'])
						)
					)
				);
			}

			$more.on('click', () => { $more.toggleClass('open'); });

			return [$more, $elems];
		}

		/**
		 * Возвращает элементы с информацией об объекте
		 * @param obj - Данные
		 */
		private getObject(obj: DebuggerVariableObjectContent): UIElement[] {
			let $more					= el('div', {class: 'more'});
			let $info					= el('div', {class: 'info'});
			let $constants				= el('div', {class: 'constants'});
			let $properties				= el('div', {class: 'properties'});
			let $methods					= el('div', {class: 'methods'});

			$info.append(
				getElement('namespace', obj['namespace']),
				getElement('class', obj['name']),
				$constants,
				$properties,
				$methods
			);

			for (const constant of obj['constants']) $constants.append(getConstant(constant, this.getVariable(constant['value'])));
			for (const property of obj['properties']) $properties.append(getProperty(property, this.getVariable(property['value'])));
			for (const method of obj['methods']) $methods.append(getMethod(method));

			$more.on('click', () => { $more.toggleClass('open'); });

			return [$more, $info];

			/**
			 * Возвращает элемент
			 * @param key - Ключ
			 * @param value Значение
			 */
			function getElement(key: string, value: string): UIElement {
				let $elem						= el('div', {class: key});
				let $icon						= el('div', {class: 'icon'});
				let $value						= el('div').text(value);

				$elem.append(
					$icon,
					$value
				);

				$value.text(value);

				return $elem;
			}

			/**
			 * Возвращает константу, представленную в виде элемента
			 * @param constant - Данные константы
			 * @param $value - Значение константы
			 */
			function getConstant(constant: DebuggerVariableObjectConstant, $value: UIElement): UIElement {
				let $elem						= el('div');
				let $icon						= el('div', {class: 'icon'});
				let $name						= el('div', {class: 'name'});

				if (constant['modifiers'].includes('public')) $icon.addClass('public');
				if (constant['modifiers'].includes('protected')) $icon.addClass('protected');
				if (constant['modifiers'].includes('private')) $icon.addClass('private');
				if (constant['modifiers'].includes('final')) $icon.addClass('final');

				$name.text(constant['name']);

				$elem.append(
					$icon,
					$name,
					$value
				);

				return $elem;
			}

			/**
			 * Возвращает переменную, представленную в виде элемента
			 * @param property - Данные переменной
			 * @param $value - Значение переменной
			 */
			function getProperty(property: DebuggerVariableObjectProperty, $value: UIElement): UIElement {
				let $elem						= el('div');
				let $icon						= el('div', {class: 'icon'});
				let $name						= el('div', {class: 'name'});

				if (property['modifiers'].includes('public')) $icon.addClass('public');
				if (property['modifiers'].includes('protected')) $icon.addClass('protected');
				if (property['modifiers'].includes('private')) $icon.addClass('private');
				if (property['modifiers'].includes('static')) $icon.addClass('static');
				if (property['modifiers'].includes('readonly')) $icon.addClass('readonly');

				$name.text(property['name']);

				$elem.append(
					$icon,
					$name,
					$value
				);

				return $elem;
			}

			/**
			 * Возвращает метод, представленный в виде элемента
			 * @param method - Название метода
			 */
			function getMethod(method: DebuggerVariableObjectMethod) {
				let $elem						= el('div');
				let $icon						= el('div', {class: 'icon'});
				let $name						= el('div');

				if (method['modifiers'].includes('public')) $icon.addClass('public');
				if (method['modifiers'].includes('protected')) $icon.addClass('protected');
				if (method['modifiers'].includes('private')) $icon.addClass('private');
				if (method['modifiers'].includes('static')) $icon.addClass('static');
				if (method['modifiers'].includes('final')) $icon.addClass('final');
				if (method['modifiers'].includes('abstract')) $icon.addClass('abstract');

				$name.text(method['name']);

				$elem.append(
					$icon,
					$name
				);

				return $elem;
			}

		}

	}

}