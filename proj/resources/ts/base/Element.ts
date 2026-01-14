type UIElement = Base.UI.Element;
type UIGroup = Base.UI.Group;
type UIElementAttributes = Base.UI.TypeElementAttributes;

namespace Base {

	export namespace UI {

		export type TypeElementAttributes = { [key: string] : string | number | boolean };
		type TypeActions = 'click' | 'change' | 'input' | 'blur';
		type TypeProperties = 'checked' | 'selected' | 'disabled';

		/**
		 * Элементы
		 */
		export class Element {
			private readonly $element: HTMLElement;

			constructor(tag: HTMLElement | string, $attributes?: TypeElementAttributes) {
				// console.log(tag);
				let elem = null;

				switch (typeof tag) {
					case 'string':
						// console.log('string');
						let regExp = /<(.+)\/>/;
						let matches = tag.match(regExp);
						if (matches?.length) {
							// console.log(matches);
							elem = document.createElement(matches[1]);
						} else {
							elem = document.querySelector(tag) as HTMLElement;
							if (!elem) throw new Error('Object not created');
						}
						break;
					case 'object':
						// console.log('object');
						elem = tag;
						break;
					default:
						throw new Error('Object not created');
				}

				this.$element = elem;

				if ($attributes) this.setAttributes($attributes);
			}

			//region getters

			/**
			 * Возвращает HTML элемент
			 */
			public getHtml(): HTMLElement {
				return this.$element;
			}

			/**
			 * Возвращает текст элемента
			 */
			public getText(): string {
				return this.$element.innerText;
			}

			/**
			 * Возвращает атрибут по имени
			 * @param name - Имя атрибута
			 */
			public getAttribute(name: string): string | null {
				return this.$element.getAttribute(name);
			}

			/**
			 * Возвращает атрибут по имени
			 * @param name - Имя атрибута
			 */
			public attr(name: string): string | null {
				return this.getAttribute(name);
			}

			/**
			 * Возвращает стиль элемента
			 * @param name - Стили
			 */
			public getStyle(name: string): string {
				return (this.$element.style as any)[name];
			}

			public val(): string | null {
				return this.attr('value');
			}

			//endregion getters

			//region setters

			/**
			 * Устанавливает атрибуты элемента
			 * @param $attributes - Перечень атрибутов
			 * @private
			 */
			public setAttributes($attributes: TypeElementAttributes): void {
				for (const $i in $attributes) {
					switch ($i) {
						case 'text': this.text($attributes[$i].toString()); break;
						default: this.$element.setAttribute($i, $attributes[$i].toString());
					}
				}
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
			 * Вставляет текст в элемент
			 * @param text - Текст
			 */
			public text(text: string = ''): Element {
				this.$element.innerText = text;

				return this;
			}

			public empty(): Element {
				this.text('');
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

			public setVal(value: string): Element {
				(this.$element as HTMLInputElement).value = value

				return this;
			}

			//endregion setters

			//region check

			/**
			 * Проверяет свойства элемента
			 * @param name - Имя свойства
			 */
			public is(name: TypeProperties): boolean | null {
				switch (name) {
					case 'checked': return (this.$element as HTMLInputElement).checked;
					case 'selected': return (this.$element as HTMLOptionElement).selected;
					case 'disabled': return (this.$element as HTMLInputElement).disabled;
				}

				return null;
			}

			/**
			 * Проверяет, существует ли класс
			 * @param className - Имя класса
			 */
			public hasClass(className: string): boolean {
				return this.$element.classList.contains(className);
			}

			//endregion check

			//region find

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
			 * Поиск вложенных элементов по селектору
			 * @param selector
			 */
			public find(selector: string): UIGroup {
				let group = new Group();

				let nodes = this.$element.querySelectorAll(selector);
				for (let i = 0; i < nodes.length; i++) {
					group.push(new Element(nodes[i] as HTMLElement));
				}

				return group;
			}

			/**
			 * Возвращает детей элемента
			 */
			public children(): UIGroup {
				let group = new Group();

				let nodes = this.$element.childNodes;
				for (let i = 0; i < nodes.length; i++) {
					group.push(new Element(nodes[i] as HTMLElement));
				}

				return group;
			}

			//endregion find

			//region insert

			/**
			 * Добавляет в конец элемента
			 * @param args - Дочерние элементы
			 */
			public append(...args: (UIElement | string | (UIElement | string)[] | null)[]): UIElement {
				for (const arg of args) {
					if (arg === null) continue;
					if (!Array.isArray(arg)) {
						this.$element.append(getHtml(arg));
					} else {
						for (const elem of arg) {
							this.$element.append(getHtml(elem));
						}
					}
				}

				function getHtml(elem: UIElement | string): string | HTMLElement {
					return typeof elem === 'string' ? elem : elem.getHtml();
				}

				return this;
			}

			public html(html: string): void {
				this.$element.innerHTML = html;
			}

			/**
			 * Вставка перед элементом
			 * @param args - Дочерние элементы
			 */
			public insertBefore(...args: (UIElement | UIElement[])[]): Element {
				let $parent = this.parent();

				for (const arg of args) {
					if (!Array.isArray(arg)) {
						$parent?.getHtml().insertBefore((arg as Element).getHtml(), this.$element);
					} else {
						for (const elem of arg) {
							$parent?.getHtml().insertBefore(elem.getHtml(), this.$element);
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
						$parent?.getHtml().insertBefore((arg as Element).getHtml(), $next);
						$next = (arg as Element).getHtml().nextSibling;
					} else {
						for (const elem of arg) {
							$parent?.getHtml().insertBefore(elem.getHtml(), $next);
							$next = elem.getHtml().nextSibling;
						}
					}
				}

				return this;
			}

			//endregion insert

			//region events

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

			public trigger(action: TypeActions): this {
				switch (action) {
					case 'click': this.$element.click(); break;
					case 'blur': this.$element.blur(); break;
					case 'change':
					case 'input':
						const event = new Event(action, { bubbles: true }); this.$element.dispatchEvent(event); break;
				}

				return this;
			}

			//endregion events

			//region actions

			public hide(): this {
				this.style({display: 'none'});
				return this;
			}

			//endregion actions

			public prop(name: string): any;
			public prop(name: string, value: string | boolean | null): this;
			public prop(name: string, value?: string | boolean | null): any {
				const element = this.$element as { [key: string]: any };

				if (arguments.length === 2) {
					element[name] = value;
					return this;
				}
				return element[name];
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

		}

		export class Group {
			private readonly elements: Element[];

			constructor(...elements: Element[]) {
				this.elements = elements ? elements : [];
			}

			// [Symbol.iterator]() {
			// 	let count = this.elements.length;
			// 	let current = 0;
			//
			// 	return {
			//
			// 		next: (): IteratorResult<Element> => {
			// 			if (current < count) {
			// 				return {value: this.elements[current++], done: false};
			// 			} else {
			// 				return {value: undefined, done: true};
			// 			}
			// 		}
			//
			// 	};
			// }

			*[Symbol.iterator](): IterableIterator<Element> {
				for (const element of this.elements) {
					yield element;
				}
			}

			public item(num: number): Element | null {
				return this.elements[num] ?? null;
			}

			private each(callback: (element: Element, index: number) => void): void {
				let index = 0;

				for (const element of this) {
					callback(element, index++);
				}
			}

			public push(element: Element) {
				this.elements.push(element);
			}

			/**
			 * Удаляет элементы
			 */
			public remove(): Group {
				this.each((element) => {
				element.remove();
				});

				return this;
			}

			/**
			 * Удаляет класс
			 * @param className - Имя класса
			 */
			public addClass(...className: string[]): Group {
				this.each((element) => {
					element.addClass(...className)
				});

				return this;
			}

			/**
			 * Удаляет класс
			 * @param className - Имя класса
			 */
			public removeClass(...className: string[]): Group {
				this.each((element) => {
					element.removeClass(...className)
				});

				return this;
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