type UIElement = Base.UI.Element;
type UIElementAttributes = Base.UI.TypeElementAttributes;

namespace Base {

	export namespace UI {

		export type TypeElementAttributes = { [key: string] : string };

		/**
		 * Элементы
		 */
		export class Element {
			private readonly $element: HTMLElement;

			constructor(tag: HTMLElement | string, $attributes?: TypeElementAttributes) {
				this.$element = tag instanceof HTMLElement ? tag : document.createElement(tag);
				if ($attributes) this.setAttributes($attributes);
			}

			/**
			 * Возвращает HTML элемент
			 */
			public html(): HTMLElement {
				return this.$element;
			}

			/**
			 * Возвращает родительский элемент
			 */
			public parent(): Element | null {
				return this.$element.parentElement ? new Element(this.$element.parentElement) : null;
			}

			/**
			 * Возвращает ближайший элемент по селектору
			 * @param selector - Селектор
			 */
			public closest(selector: string): Element | null {
				return this.$element.closest(selector) ? new Element(this.$element.closest(selector) as HTMLElement) : null;
			}

			/**
			 * Возвращает предыдущий элемент
			 */
			public previous(): Element | null {
				return this.$element.previousElementSibling ? new Element(this.$element.previousElementSibling as HTMLElement) : null;
			}

			/**
			 * Возвращает следующий элемент
			 */
			public next(): Element | null {
				return this.$element.nextElementSibling ? new Element(this.$element.nextElementSibling as HTMLElement) : null;
			}

			/**
			 * Добавляет в конец элемента
			 * @param args - Дочерние элементы
			 */
			public append(...args: (UIElement | string | (UIElement | string)[])[]): UIElement {
				for (const arg of args) {
					if (!Array.isArray(arg)) {
						this.$element.append(getHtml(arg));
					} else {
						for (const elem of arg) {
							this.$element.append(getHtml(elem));
						}
					}
				}

				function getHtml(elem: UIElement | string): string | HTMLElement {
					return typeof elem === 'string' ? elem : elem.html();
				}

				return this;
			}

			/**
			 * Вставка перед элементом
			 * @param args - Дочерние элементы
			 */
			public insertBefore(...args: (UIElement | UIElement[])[]): Element {
				let $parent = this.parent();

				for (const arg of args) {
					if (!Array.isArray(arg)) {
						$parent?.html().insertBefore((arg as Element).html(), this.$element);
					} else {
						for (const elem of arg) {
							$parent?.html().insertBefore(elem.html(), this.$element);
						}
					}
				}

				return this;
			}

			/**
			 * Вставка после элемента
			 * @param args - Дочерние элементы
			 */
			public insertAfter(...args: (UIElement | UIElement[])[]): Element {
				let $parent = this.parent();
				let $next = this.$element.nextSibling;

				for (const arg of args) {
					if (!Array.isArray(arg)) {
						$parent?.html().insertBefore((arg as Element).html(), $next);
						$next = (arg as Element).html().nextSibling;
					} else {
						for (const elem of arg) {
							$parent?.html().insertBefore(elem.html(), $next);
							$next = elem.html().nextSibling;
						}
					}
				}

				return this;
			}

			/**
			 * Проверяет свойства элемента
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
				for (const $i in $attributes) {
					switch ($i) {
						case 'text': this.text($attributes[$i]); break;
						default: this.$element.setAttribute($i, $attributes[$i]);
					}
				}
			}

			/**
			 * Возвращает атрибут по имени
			 * @param name - Имя атрибута
			 */
			public getAttribute(name: string): string | null {
				return this.$element.getAttribute(name);
			}

			/**
			 * Проверяет, существует ли класс
			 * @param className - Имя класса
			 */
			public hasClass(className: string): boolean {
				return this.$element.classList.contains(className);
			}

			/**
			 * Добавляет класс
			 * @param className - Имя класса
			 */
			public addClass(...className: string[]): Element {
				this.$element.classList.add(...className);

				return this;
			}

			/**
			 * Удаляет класс
			 * @param className - Имя класса
			 */
			public removeClass(...className: string[]): Element {
				this.$element.classList.remove(...className);

				return this;
			}

			/**
			 * Переключает класс
			 * @param className - Имя класса
			 */
			public toggleClass(className: string): Element {
				this.hasClass(className) ? this.removeClass(className) : this.addClass(className);

				return this;
			}

			/**
			 * Добавление стилей к элементу
			 * @param styles - Стили
			 */
			public style(styles: Record<string, string | number>): Element {
				for (const name in styles) {
					(this.$element.style as any)[name] = styles[name].toString();
				}

				return this;
			}

			/**
			 * Возвращает стиль элемента
			 * @param name - Стили
			 */
			public getStyle(name: string): string {
				return (this.$element.style as any)[name];
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
			 * Открепляет обработчик события
			 * @param name - Имя события
			 * @param callback - Обработчик
			 */
			public off(name: string, callback: (event: Event) => void): Element {
				this.$element.removeEventListener(name, callback);

				return this;
			}

			/**
			 * Определение элемента в качестве цели захвата для будущих событий указателя
			 * @param id
			 */
			public setPointerCapture(id: number): Element {
				this.$element.setPointerCapture(id);

				return this;
			}

			/**
			 * Удаляет элемент
			 */
			public remove(): void {
				this.$element.remove();
			}

			/**
			 * Поиск вложенных элементов по селектору
			 * @param selector
			 */
			public find(selector: string): NodeList {
				return this.$element.querySelectorAll(selector);
			}

		}

	}

}

(typeof (globalThis as any).Base === 'undefined')
	? (globalThis as any).Base = Base
	: (
		typeof (globalThis as any).Base.UI === 'undefined'
			? (globalThis as any).Base.UI = Base.UI
			: Object.assign((globalThis as any).Base.UI, Base.UI)
	)