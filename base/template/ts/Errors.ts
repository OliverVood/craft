namespace Base {

	import createElement = PragmaJSX.createElement;

	/**
	 * Работа с ошибками
	 */
	export class Errors {

		/**
		 * Запускает обработку с ошибок
		 * @param data
		 */
		public static execute(data: Record<string, string[]>) {
			document.querySelectorAll('div.field').forEach(($element) => { $element.classList.remove('error'); });
			document.querySelectorAll('div.field > .errors').forEach(($element) => { $element.innerHTML = ''; });

			for (const keyData in data) {
				let $cover = document.querySelector(`div.field[data-name="${keyData}"]`);
				let $errors = document.querySelector(`div.field[data-name="${keyData}"] > div.errors`);

				if (!$cover || !$errors) continue;

				let errors = data[keyData];

				$cover.classList.add('error');
				for (const keyError in errors) {
					$errors.append(
						el('span')
							.text(errors[keyError])
							.html()
					);
				}
			}
		}

	}

}