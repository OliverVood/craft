/**
 * Запрашивает контент страницы
 * @param route
 */
function getContent(route: string = ''): void {
	let url = new URL(window.location.href);

	let pathname = url.pathname.slice(route.length + 1);
	let params = url.search;

	Base.Request.address(`${pathname}${params}`, {method: 'get'}).then(result => Base.Response.execute(result));
}

/**
 * Функция декоратор для создания элементов
 * @param $name - Имя элемента
 * @param attributes - Атрибуты элемента
 */
function el($name: string, attributes?: Base.TypeElementAttributes): Base.Element {
	return new Base.Element($name, attributes);
}

type CookieOptionsKeys = 'path' | 'secure' | 'expires';
type CookieOptions = { path?: string;
	// domain?: string;
	expires?: Date;
	secure?: boolean;
	// sameSite?: 'Lax' | 'Strict' | 'None';
};

/**
 * Устанавливает куки
 * @param name - Название
 * @param value - Значение
 * @param options - Опции
 */
function setCookie(name: string, value: string, options: CookieOptions = {}) {
	let attributes = {
		path: '/',
		...options,
	};

	let cookie = `${ encodeURIComponent(name) }=${ encodeURIComponent(value) }`;

	let t = [];
	for (const key in attributes) {
		let value = attributes[key as CookieOptionsKeys];

		switch (typeof value) {
			case 'boolean': if (value) value = ''; break;
			case 'string': value = `=${ value }`; break;
			case 'object': value = `=${ value.toUTCString() }`; break;
		}

		cookie += `; ${ key }${ value }`;
	}

	document.cookie = cookie;
}

/**
 * Функция перевода
 * @param text - Текст для перевода
 */
function __(text: string): string {
	return text;
}