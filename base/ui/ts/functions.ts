/**
 * Запрашивает контент страницы
 * @param route
 */
function getContent(route: string = ''): void {
	let url = new URL(window.location.href);

	let pathname = url.pathname.slice(route.length + 1);
	let params = url.search;

	Base.Request.address(`${pathname}${params}`).then(result => Base.Response.execute(result));
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