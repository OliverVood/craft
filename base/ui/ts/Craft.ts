namespace Base {

	/**
	 * Работает с классами Craft
	 */
	export namespace Craft {

		/**
		 * Работа со структурами
		 */
		export class Structure {
			/**
			 * Добавляет таблицу
			 * @param $th - Переключатель
			 */
			public static addTable($th: HTMLElement): void {
				let $btn = el($th);
				let $items = $btn.previous();

				let $item = el('div', {class: 'table'});
				let $input = el('input', {type: 'text', name: 'params[table][]', placeholder: __('Название таблицы')});
				let $delete = el('span', {text: 'X', class: 'delete'}).on('click', () => { $item.remove(); });

				($items as Base.UI.Element).append(
					$item.append(
						$input,
						$delete
					)
				);
			}

		}

		/**
		 * Работа с контроллерами
		 */
		export class Controller {
			/**
			 * Добавляет модель
			 * @param $th - Переключатель
			 */
			public static addModel($th: HTMLElement): void {
				let $checkboxModelInput = el($th);
				let $checkboxModel = ($checkboxModelInput.parent() as Base.UI.Element).parent() as Base.UI.Element;

				if (!$checkboxModelInput.is('checked')) {
					$checkboxModel.next()?.remove();
					return;
				}

				let $wrap = el('div');
				let $checkboxBD = checkbox(__('Использовать базу данных'));

				$checkboxBD.change((state: boolean) => {
					state ? this.addDatabase($checkboxBD) : this.removeDatabase($checkboxBD);
				});

				$checkboxModel.insertAfter(
					$wrap.append(
						$checkboxBD
					)
				);
			}

			/**
			 * Добавляет базу данных
			 * @param $checkboxBD
			 */
			public static addDatabase($checkboxBD: UICheckboxElement): void {
				let $wrap = el('div');
				let $input = el('input', {type: 'text', name: 'params[database]', placeholder: __('База данных')});

				$checkboxBD.insertAfter(
					$wrap.append(
						$input
					)
				);
			}

			/**
			 * Добавляет базу данных
			 * @param $th - Переключатель
			 */
			public static addDatabaseForModel($th: HTMLElement): void {
				let $checkboxInput: UIElement = el($th);
				let $checkboxBD: UIElement = $checkboxInput.parent()?.parent() as UIElement;

				if (!$checkboxInput.is('checked')) {
					$checkboxBD.next()?.remove();
					return;
				}

				let $wrap = el('div');
				let $input = el('input', {type: 'text', name: 'params[database]', placeholder: __('База данных')});

				$checkboxBD.insertAfter(
					$wrap.append(
						$input
					)
				);
			}

			/**
			 * Удаляет базу данных
			 * @param $checkboxBD
			 */
			public static removeDatabase($checkboxBD: UICheckboxElement): void {
				$checkboxBD.next()?.remove();
			}

		}

	}

}