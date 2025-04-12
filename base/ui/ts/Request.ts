namespace Base {

	type RequestOptionsCredentials 		= 'include' | 'omit' | 'same-origin';
	type RequestOptionsCache 			= 'default' | 'force-cache' | 'no-cache' | 'no-store' | 'only-if-cached' | 'reload';

	/**
	 * XHR запросы
	 */
	export class Request {

		public static xhr(address: string, data: BodyInit): Promise<Response> {
			let xhr = GlobalParams.get('xhr');
			let url = `${xhr}${address}`;

			let timezone = `Etc/GMT${(new Date().getTimezoneOffset()) / 60}`;
			setCookie('timezone', timezone);

			return new Promise((resolve, reject) => {
				fetch(url, Request.getInit(data/*, options*/)).then(async response => {
					let result = await response.json();
					if (response.status !== 200 && response.status !== 201) {
						Response.error(result);
						reject(result);
					}
					resolve(result);
				}).catch(error => {
					console.error(`Request failed: ${url}`, data, error);
					reject({});
				});
			});
		}

		/**
		 * Отправляет запрос по адресу
		 * @param address - Адрес запроса
		 */
		public static address(address: string): Promise<Response> {
			return Request.xhr(address, '');
		}

		/**
		 * Отправляет запрос с объектом данных по адресу
		 * @param address - Адрес запроса
		 * @param data - Объект данных
		 */
		public static data(address: string, data: Object): Promise<Response> {
			return Request.xhr(address, JSON.stringify(data));
		}

		public static form(form: HTMLFormElement, options?: any/*RequestOptions*/): Promise<Response> {
			let url = form.getAttribute('action') as string;
			let formData = new FormData(form);

			return Request.xhr(url, formData/*, options*/);
		}

		public static submit(element: HTMLElement): Promise<Response> {
			return Request.form(element.closest('form') as HTMLFormElement);
		}

		private static getInit(data: BodyInit/*, options?: RequestOptions*/): RequestInit {
			let method			: string						= 'post';
			let cache			: RequestOptionsCache			= 'no-cache';
			let credentials		: RequestOptionsCredentials		= 'same-origin';

			/*if (options) {
				if (options.method) method = options.method;
				if (options.cache) cache = options.cache;
				if (options.credentials) credentials = options.credentials;
			}*/

			let init: RequestInit = {
				method: method,
				cache: cache,
				credentials: credentials
			};

			/*if (options?.method !== 'get')*/ init['body'] = data;

			return init;
		}

		// /**
		//  * Отправляет данные. Каждый XHR запрос должен проходить через данный метод.
		//  * @param address - Адрес запроса
		//  * @param data - Данные
		//  * @param handler - Обработчик
		//  * @param params - Параметры
		//  */
		// public static send(address: string, data: Object, handler?: Function, params?: TypeRequestParams): void {
		// 	let method			: string			= 'post';
		// 	let request 		: string			= GlobalParams.get('xhr');
		// 	let contentType		: string | false	= 'application/x-www-form-urlencoded;charset=UTF-8';
		// 	let processData		: boolean			= true;
		//
		// 	if (params) {
		// 		if (params.method) method = params.method;
		// 		if (params.request !== undefined) request = params.request;
		// 		if (params.contentType !== undefined) contentType = params.contentType;
		// 		if (params.processData !== undefined) processData = params.processData;
		// 	}
		//
		// 	let url				: string			= `${request}${address}`;
		//
		// 	switch (Query.technology) {
		// 		case 'jq': Query.xhrJQ(url, method, data, contentType, processData, handler); break;
		// 		case 'xhr': Query.xhrXMLHttpRequest(); break;
		// 		case 'fetch': Query.xhrFetch(); break;1
		// 	}
		// }

		// /**
		//  * Отправляет форму
		//  * @param form - Форма
		//  * @param handler - Обработчик
		//  */
		// public static sendForm(form: HTMLFormElement, handler?: Function) {
		// 	Query.send(form.getAttribute('action') as string, new FormData(form), handler, {contentType: false, processData: false});
		// }
		//
		// /**
		//  * Отправляет форму. Инициатор внутренний элемент.
		//  * @param element - Элемент в форме
		//  * @param handler - Обработчик
		//  */
		// public static submitForm(element: HTMLElement, handler?: Function): void {
		// 	Query.sendForm(element.closest('form') as HTMLFormElement, handler);
		// }
		//
		// /**
		//  * Отправляет методом ajax JQuery
		//  * @param url - URL
		//  * @param method - Метод
		//  * @param data - Данные
		//  * @param contentType - Тип контента
		//  * @param processData - Прогресс
		//  * @param handler - Обработчик
		//  * @private
		//  */
		// private static xhrJQ(url: string, method: string, data: Object, contentType: string | false, processData: boolean, handler?: Function): void {
		// 	$.ajax({
		// 		url				: url,
		// 		method			: method,
		// 		dataType		: 'json',
		// 		data 			: data,
		// 		contentType		: contentType,
		// 		processData		: processData,
		// 		cache			: false,
		// 		// beforeSend: function() { if (funcBeforeSend) funcBeforeSend(); },
		// 		// complete: function() { if (funcComplete) funcComplete(); },
		// 		success			: function(response) { Base.Response.run(response, handler ? handler : undefined); },
		// 		error			: function(response) { console.log('request failed: ' + url); console.log(response); }
		// 	});
		// }
		//
		// /**
		//  * Отправляет методом MLHttpRequest
		//  * @private
		//  */
		// private static xhrXMLHttpRequest(): void {
		// 	// let xhr = new XMLHttpRequest();
		// 	// xhr.open(method, `${request}${address}`);
		// 	// xhr.send(data);
		// 	// xhr.responseType = 'json';
		// 	// xhr.setRequestHeader('Content-Type', contentType ? contentType : '');
		// 	// xhr.onload = function() {
		// 	// 	alert(`Загружено: ${xhr.status} ${xhr.response}`);
		// 	// };
		// 	//
		// 	// xhr.onerror = function() { // происходит, только когда запрос совсем не получилось выполнить
		// 	// 	alert(`Ошибка соединения`);
		// 	// };
		// }
		//
		// /**
		//  * Отправляет методом fetch
		//  * @private
		//  */
		// private static xhrFetch(): void {
		// 	// fetch()
		// 	// .then((response) => {
		// 	// 	Base.Response.run(response, handler ? handler : undefined);
		// 	// }).
		// 	// catch((response) => {
		// 	// 	console.log('request failed: ' + address); console.log(response);
		// 	// });
		// }

	}

}