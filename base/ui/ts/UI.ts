/**
 * Функция декоратор для создания элементов
 * @param $name - Имя элемента
 * @param attributes - Атрибуты элемента
 */
function el($name: HTMLElement | string, attributes?: UIElementAttributes): UIElement {
	return Base.UI.Factory.getInstance().create($name, attributes);
}

/**
 * Создаёт компонент checkbox
 * @param label - Текст надписи
 */
function checkbox(label: string): UICheckboxElement {
	return new Base.UI.Components.Checkbox(label);
}