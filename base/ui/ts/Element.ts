namespace Base {

	export type TypeElementAttributes = { [key: string] : string };

	/**
	 * Работает с dom элементами
	 */
	export class Element {
		private readonly $element: HTMLElement;

		constructor(name: string, $attributes?: TypeElementAttributes) {
			this.$element = document.createElement(name);
			if ($attributes) this.setAttributes($attributes);
		}

		/**
		 * Возвращает HTML элемент
		 */
		public html(): HTMLElement {
			return this.$element;
		}

		/**
		 * Добавление дочерних элементов
		 * @param args - Дочерние элементы
		 */
		public append(...args: (Base.Element | Base.Element[])[]): Element {
			for (const arg of args) {
				if (!Array.isArray(arg)) {
					this.$element.append((arg as Element).html());
				} else {
					for (const elem of arg) {
						this.$element.append(elem.html());
					}
				}
			}

			return this;
		}

		/**
		 * Вставляет текст в элемент
		 * @param text - Текст
		 */
		public text(text: string = ''): Element {
			this.$element.innerText = text;

			return this;
		}

		/**
		 * Навешивает обработчик события
		 * @param name - Имя события
		 * @param callback - Обработчик
		 */
		public on(name: string, callback: (event: Event) => void): Element {
			this.$element.addEventListener(name, callback);

			return this;
		}

		/**
		 * Проверка свойства элемента
		 * @param name - Имя свойства
		 */
		public is(name: string): boolean | null {
			switch (name) {
				case 'checked': return (this.$element as HTMLInputElement).checked;
			}

			return null;
		}

		/**
		 * Устанавливает атрибуты элемента
		 * @param $attributes - Перечень атрибутов
		 * @private
		 */
		private setAttributes($attributes: TypeElementAttributes): void {
			for (const $i in $attributes) this.$element.setAttribute($i, $attributes[$i]);
		}

		/**
		 * Возвращает атрибут по имени
		 * @param name - Имя атрибута
		 */
		public getAttribute(name: string): string | null {
			return this.$element.getAttribute(name);
		}

	}

}