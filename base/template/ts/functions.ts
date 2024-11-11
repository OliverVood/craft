/**
 * Запрашивает контент страницы
 * @param route
 */
function getContent(route: string = ''): void {
	let url = new URL(window.location.href);

	let href = url.origin;
	let pathname = route ? url.pathname.replace(route, `${route}/xhr`) : `/xhr${url.pathname}`;
	let params = url.search;

	Base.Query.sendToAddress(`${href}${pathname}${params}`, undefined, {request: ''});
}

/**
 * Функция декоратор для создания элементов
 * @param $name - Имя элемента
 * @param attributes - Атрибуты элемента
 */
function el($name: string, attributes?: Base.TypeElementAttributes): Base.Element {
	return new Base.Element($name, attributes);
}

/**
 * Функция перевода
 * @param text - Текст для перевода
 */
function __(text: string): string {
	return text;
}