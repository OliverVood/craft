namespace Admin {

	export namespace DB {

		export namespace Render {

			type TypeDataTable = { name: string, action: number, description: string, fields?: TypeDataFields };
			type TypeDataTables = TypeDataTable[];
			type TypeDataField = { name: string, action: number, description: string, details: string };
			type TypeDataFields = TypeDataField[];

			/**
			 * Отрисовка проверки базы данных
			 */
			export abstract class Check {
				/**
				 * Отрисовка данных проверки базы данных
				 * @param data - Данные
				 * @param action - Ссылка формы
				 */
				public static init(data: TypeDataTables, action: string): void {
					let $container = document.querySelector('.view.db.check') as HTMLDivElement;

					$container.innerHTML = '';

					data.length ? Check.form($container, data, action) : Check.empty($container);
				}

				/**
				 * Отрисовка формы, если есть данные для исправления
				 * @param $container - Контейнер
				 * @param data - Данные
				 * @param action - Ссылка формы
				 */
				private static form($container: HTMLDivElement, data: TypeDataTables, action: string) {
					/* Elements */
					let $form = el('form', {action: action});
					let $table = el('table', {class: 'select'});
					let $tbody = el('tbody');
					let $submit = el('input', {type: 'submit', value: 'Исправить'});
					let $checkbox = el('input', {type: 'checkbox'});

					/* Building DOM */
					$form.append(
						$table.append(
							el('thead').append(
								el('tr').append(
									el('th').text('Таблица'),
									el('th').text('Поле'),
									el('th').append($checkbox),
									el('th').text('Ошибка')
								)
							),
							$tbody
						),
						$submit
					);
					$container.append($form.html());

					Check.tables($tbody, data);

					/* Events */
					$checkbox.on('click', () => { onSelectAll(!!$checkbox.is('checked')); });
					$submit.on('click', (event) => { onSubmit(); event.preventDefault(); });

					/* Handlers */
					function onSelectAll(state: boolean): void {
						$tbody.html().querySelectorAll('input[type="checkbox"]').forEach((el: Element) => {
							(el as HTMLInputElement).checked = state;
						});
					}

					function onSubmit(): void {
						Base.QueryWait.sendFormJSON($form).then((data) => {
							console.log(data);
							Check.init(data.data, data.action);
						});
					}
				}

				/**
				 * Отрисовка таблиц
				 * @param $tbody - Тело таблицы
				 * @param tables - Данные таблиц
				 * @private
				 */
				private static tables($tbody: Base.Element, tables: TypeDataTables): void {
					for (let table of tables) Check.table($tbody, table);
				}

				/**
				 * Отрисовка таблицы
				 * @param $tbody - Тело таблицы
				 * @param table - Данные таблицы
				 * @private
				 */
				private static table($tbody: Base.Element, table: TypeDataTable): void {
					/* Elements */
					let $checkbox = el('input', {type: 'checkbox', name: `tables[${table.name}][action]`, value: table.action.toString()});

					/* Building DOM */
					$tbody.append(
						el('tr').append(
							el('td').text(table.name),
							el('td').text('-'),
							el('td').append(
								$checkbox
							),
							el('td').text(table.description)
						)
					);

					/* Events */
					$checkbox.on('click', () => { onSelectTable(); });

					/* Handlers */
					function onSelectTable(): void {
						let state = !!$checkbox.is('checked');

						document.querySelectorAll(`input[name^="tables[${table.name}][fields]"]`).forEach((element) => {
							(element as HTMLInputElement).checked = state;
						});
					}

					if (table.fields) Check.fields($tbody, table.name, table.fields);
				}

				/**
				 * Отрисовка полей
				 * @param $tbody - Тело таблицы
				 * @param tableName - Название таблицы
				 * @param fields - Данные полей
				 * @private
				 */
				private static fields($tbody: Base.Element, tableName: string, fields: TypeDataFields) {
					for (let i in fields) Check.field($tbody, tableName, fields[i]);
				}

				/**
				 * Отрисовка поля
				 * @param $tbody - Тело таблицы
				 * @param tableName - Название таблицы
				 * @param field - Данные поля
				 * @private
				 */
				private static field($tbody: Base.Element, tableName: string, field: TypeDataField) {
					/* Elements */
					let $checkbox = el('input', {type: 'checkbox', name: `tables[${tableName}][fields][${field.name}][action]`, value: field.action.toString()});
					let textError = field.description + ((field.details) ? ` (${field.details})` : '');

					/* Building DOM */
					$tbody.append(
						el('tr').append(
							el('td').text(tableName),
							el('td').text(field.name),
							el('td').append(
								$checkbox
							),
							el('td').text(textError)
						)
					);

					/* Events */
					$checkbox.on('click', () => { onSelectField(); });

					/* Handlers */
					function onSelectField(): void {
						if ($checkbox.is('checked')) {
							(document.querySelector(`input[name^="tables[${tableName}][action]"]`) as HTMLInputElement).checked = true;
							return;
						}

						let $fields = document.querySelectorAll(`input[name^="tables[${tableName}][fields]"]`);
						for (const i in $fields) if (($fields[i] as HTMLInputElement).checked) return;

						(document.querySelector(`input[name^="tables[${tableName}][action]"]`) as HTMLInputElement).checked = false;
					}
				}

				/**
				 * Отрисовка сообщения, если данных для исправления нет
				 * @param $container - Контейнер
				 */
				private static empty($container: HTMLDivElement) {
					let h3 = el('h3').text(__('База данных исправна.'));

					$container.append(
						h3.html()
					);
				}

			}

		}

	}

}