/**
 * Функция декоратор для создания элементов
 * @param $name - Имя элемента
 * @param attributes - Атрибуты элемента
 */
function el($name: HTMLElement | string, attributes?: UIElementAttributes): UIElement {
	return globalThis.Base.UI.Factory.getInstance().create($name, attributes);
}

(globalThis as any).el = el;