namespace Base {

	/**
	 * Работа с ошибками
	 */
	export class Errors {

		public static clear(): void {
			document.querySelectorAll('div[data-field]').forEach(($element) => { $element.classList.remove('error'); });
			document.querySelectorAll('div[data-field] > .errors').forEach(($element) => { $element.innerHTML = ''; });
		}

		/**
		 * Запускает обработку с ошибок
		 * @param data
		 */
		public static execute(data: Record<string, string[]>, clear: boolean = true): void {
			if (clear) this.clear();

			for (const keyData in data) {
				let $cover = document.querySelector(`div[data-field="${keyData}"]`);
				let $errors = document.querySelector(`div[data-field="${keyData}"] > div.errors`);

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

(typeof (globalThis as any).Base === 'undefined')
	? (globalThis as any).Base = Base
	: Object.assign((globalThis as any).Base, Base);