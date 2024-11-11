namespace PragmaJSX {

	/**
	 * Выполняет элемент TSX
	 * @param tag - Тег
	 * @param props - Свойства
	 * @param children - Дочерние элементы
	 */
	export function createElement(tag: string | Function, props: { [key: string]: string }, ...children: any[]): any {
		switch (typeof tag) {
			case 'function': return tag(props, ...children);
			case 'undefined': return getFragment(props, ...children);
			default: return getElement(tag, props, ...children);
		}
	}

	/**
	 * Создаёт элемент
	 * @param tag - Тег
	 * @param props - Свойства
	 * @param children - Дочерние элементы
	 * @private
	 */
	function getElement(tag: string, props: { [key: string]: string }, ...children: any[]) {
		const element = document.createElement(tag);

		Object.entries(props || {}).forEach(([name, value]) => {
			switch (name.startsWith('on') && name.toLowerCase() in window) {
				case true: addEvent(element, name, value as any); break;
				case false: addAttr(element, name, value as any); break;
			}
		});

		children.forEach(child => {
			appendChild(element, child);
		});

		return element;
	}

	/**
	 * Добавляет обработчик события
	 * @param element - Элемент
	 * @param name - Наименование события
	 * @param value - Обработчик
	 * @private
	 */
	function addEvent(element: HTMLElement, name: string, value: EventListenerOrEventListenerObject) {
		name.toLowerCase().substring(0, 2)
		element.addEventListener(name.toLowerCase().substring(2), value);
	}

	/**
	 * Добавляет атрибуты
	 * @param element - Элемент
	 * @param name - Наименование атрибута
	 * @param value - Значение атрибута
	 * @private
	 */
	function addAttr(element: HTMLElement, name: string, value: string) {
		switch (name) {
			case 'className': element.setAttribute('class', value); break;
			default: element.setAttribute(name, value);
		}
	}

	/**
	 * Создаёт фрагмент
	 * @param props - свойства
	 * @param children - Потомки
	 * @private
	 */
	function getFragment(props: { [key: string]: string }, ...children: any[]) {
		return children;
	}

	/**
	 * Добавление потомков
	 * @param parent - Родитель
	 * @param child - Потомок
	 * @private
	 */
	function appendChild(parent: any, child: any) {
		if (Array.isArray(child)) {
			child.forEach(nestedChild => appendChild(parent, nestedChild));
		} else {
			parent.appendChild(child.nodeType ? child : document.createTextNode(child));
		}
	}

}