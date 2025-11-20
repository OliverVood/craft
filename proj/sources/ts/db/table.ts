namespace Admin {

	export namespace DB {

		/**
		 * Работа экземпляром таблицы структуры
		 */
		export class Table {
			public fields								: { [key: string]: Field };

			private readonly $table						: HTMLDivElement;
			private readonly $drag						: HTMLDivElement;
			private readonly $head						: HTMLDivElement;
			private readonly $title						: HTMLDivElement;
			private readonly $name						: HTMLDivElement;
			private readonly $description				: HTMLDivElement;
			private readonly $menu						: HTMLDivElement;
			private readonly $rows						: HTMLDivElement;
			private readonly $keys						: HTMLDivElement;

			constructor(db: DBInstance, data: DataTable, $structure: HTMLElement) {
				this.fields = {};

				this.$table = document.createElement('div');
				this.$table.className = 'table';
				this.$drag = document.createElement('div');
				this.$drag.className = 'drag';
				this.$head = document.createElement('div');
				this.$head.className = 'header';
				this.$title = document.createElement('div');
				this.$title.className = 'title';
				this.$name = document.createElement('div');
				this.$name.className = 'name';
				this.$description = document.createElement('div');
				this.$description.className = 'description';
				this.$menu = document.createElement('div');
				this.$menu.className = 'menu';
				this.$rows = document.createElement('div');
				this.$rows.className = 'rows';
				this.$keys = document.createElement('div');
				this.$keys.className = 'keys';

				this.$name.innerText = data.name;
				this.$description.innerText = data.description;
				this.$menu.innerText = '▼';

				this.$table.append(this.$drag, this.$head, this.$rows, this.$keys);
				this.$head.append(this.$title, this.$menu);
				this.$title.append(this.$name, this.$description);
				$structure.append(this.$table);

				this.setPosition(data.name);
				this.hoverElement(db);
				this.dragAndDrop(this.$drag, this.$table, data.name);

				for (const field of data['fields']) this.fields[field.name] = new globalThis.Admin.DB.Field(field, this.$rows);
			}

			/**
			 * Отображение ключа в таблице
			 * @param $key - Ключ
			 */
			public appendKey($key: HTMLDivElement): void {
				this.$keys.append(
					$key
				);
			}

			/**
			 * Устанавливает позицию таблицы
			 * @param name - Название таблицы
			 * @private
			 */
			private setPosition(name: string) {
				let left, top;
				let position = localStorage.getItem(`structure_table_${name}`);
				if (position) {
					[left, top] = position.split(',');
					this.$table.style.left = `${left}px`;
					this.$table.style.top = `${top}px`;
				}
			}

			/**
			 * Обработчик перемещения таблицы
			 * @param $drag - За что перетаскиваем
			 * @param $elem - Что перетаскиваем
			 * @param name - Название таблицы
			 * @private
			 */
			private dragAndDrop($drag: HTMLElement, $elem: HTMLElement, name: string): void {
				$drag.onpointerdown = event => {
					$drag.setPointerCapture(event.pointerId);

					let startClientX = event.clientX;
					let startClientY = event.clientY;
					let startLeft = $elem.offsetLeft;
					let startTop = $elem.offsetTop;

					let left = 0;
					let top = 0;

					$drag.onpointermove = event => {
						let alphaX = startClientX - event.clientX;
						let alphaY = startClientY - event.clientY;

						left = startLeft - alphaX;
						if (left < 0) left = 0;
						top = startTop - alphaY;
						if (top < 0) top = 0;

						$elem.style.left = `${left}px`;
						$elem.style.top = `${top}px`;
					};

					$drag.onpointerup = () => {
						$drag.onpointermove = null;
						$drag.onpointerup = null;

						localStorage.setItem(`structure_table_${name}`, [left, top].join(','));
					};
				};
			}

			/**
			 * Обработчик наведения на таблицу
			 * @param db - Экземпляр БД структуры
			 * @private
			 */
			private hoverElement(db: DBInstance) {
				this.$table.addEventListener('mouseover', () => db.hoverElement(this.$table));
			}

		}

	}

}

(typeof (globalThis as any).Admin === 'undefined')
	? (globalThis as any).Admin = Admin
	: (
		typeof (globalThis as any).Admin.DB === 'undefined'
			? (globalThis as any).Admin.DB = Admin.DB
			: Object.assign((globalThis as any).Admin.DB, Admin.DB)
	);