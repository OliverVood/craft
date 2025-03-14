namespace Base {

	/**
	 * Работа с секциями
	 */
	export class Section {

		/**
		 * Добавляет контент в секцию
		 * @param section - Секция
		 * @param html - Контент
		 * @param empty - Очистить ли секцию
		 */
		public static append(section: string, html: string, empty: boolean): void {
			let $section = document.querySelector(`.section.${section}`);
			if (!$section) return;

			if (empty) $section.innerHTML = "";
			$section.innerHTML += html;

			Section.eval(html);
		}

		/**
		 * Выполняет скрипты из контента
		 * @param html - Контент
		 * @private
		 */
		private static eval(html: string): void {
			let parser = new DOMParser();
			let $doc = parser.parseFromString(html, 'text/html');

			let $scripts = $doc.querySelectorAll('script');
			for (const i in $scripts) {
				let $script = document.createElement('script');
				$script.textContent = $scripts[i].textContent;
				document.body.appendChild($script);
			}
		}

	}

}