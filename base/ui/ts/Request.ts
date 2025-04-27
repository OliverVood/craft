namespace Base {

	type RequestOptionsMethod			= 'get' | 'post' | 'delete' | 'patch' | 'put';
	type RequestOptionsCredentials 		= 'include' | 'omit' | 'same-origin';
	type RequestOptionsCache 			= 'default' | 'force-cache' | 'no-cache' | 'no-store' | 'only-if-cached' | 'reload';
	type RequestOptions					= {
		method							?: RequestOptionsMethod,
		cache							?: RequestOptionsCache,
		credentials						?: RequestOptionsCredentials,
		json?: boolean
	}

	/**
	 * XHR запросы
	 */
	export class Request {

		public static xhr(address: string, data: BodyInit, options?: RequestOptions): Promise<Response> {
			let xhr = GlobalParams.get('xhr');
			let url = `${xhr}${address}`;

			let timezone = `Etc/GMT${(new Date().getTimezoneOffset()) / 60}`;
			setCookie('timezone', timezone);

			return new Promise((resolve, reject) => {
				fetch(url, Request.getInit(data, options)).then(async response => {
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
		 * @param options - Опции
		 */
		public static address(address: string, options?: RequestOptions): Promise<Response> {
			return Request.xhr(address, '', options);
		}

		/**
		 * Отправляет запрос GET по адресу
		 * @param address - Адрес запроса
		 */
		public static get(address: string): Promise<Response> {
			return Request.xhr(address, '', {method: 'get'});
		}

		/**
		 * Отправляет запрос DELETE по адресу
		 * @param address - Адрес запроса
		 * @param data - Объект данных
		 */
		public static delete(address: string, data: Object = ''): Promise<Response> {
			return Request.data(address, data, {method: 'delete'});
		}

		/**
		 * Отправляет запрос с объектом данных по адресу
		 * @param address - Адрес запроса
		 * @param data - Объект данных
		 * @param options - Опции
		 */
		public static data(address: string, data: Object, options?: RequestOptions): Promise<Response> {
			return Request.xhr(address, JSON.stringify(data), options);
		}

		/**
		 * Отправляет форму
		 * @param form - Форма
		 * @param options - Опции
		 */
		public static form(form: HTMLFormElement, options?: RequestOptions): Promise<Response> {
			let url = form.getAttribute('action') as string;
			let formData = new FormData(form);

			return Request.xhr(url, options?.json ? JSON.stringify(this.formDataToObject(formData)) : formData, options);
		}

		/**
		 * Отправляет форму через submit
		 * @param element - Элемент
		 * @param options - Опции
		 */
		public static submit(element: HTMLElement, options?: RequestOptions): Promise<Response> {
			return Request.form(element.closest('form') as HTMLFormElement, options);
		}

		/**
		 * Возвращает настройки для инициализации запроса
		 * @param data
		 * @param options
		 * @private
		 */
		private static getInit(data: BodyInit, options?: RequestOptions): RequestInit {
			let method			: string						= 'post';
			let cache			: RequestOptionsCache			= 'no-cache';
			let credentials		: RequestOptionsCredentials		= 'same-origin';

			if (options) {
				if (options.method) method = options.method;
				if (options.cache) cache = options.cache;
				if (options.credentials) credentials = options.credentials;
			}

			let init: RequestInit = {
				method: method,
				cache: cache,
				credentials: credentials
			};
			if (options?.method != 'get') init.body = data;
			if (options?.json) init['headers'] = { 'Content-Type': 'application/json' };

			return init;
		}

		/**
		 * Преобразует FormData в объект
		 * @param formData - Данные формы
		 * @private
		 */
		private static formDataToObject(formData: FormData): Record<string, any> {
			const data = {};

			formData.forEach((value, key) => {
				const keys = key.split(/]\[|\[|]/).filter(Boolean);
				let current: any = data;

				keys.forEach((k, i) => {
					if (i === keys.length - 1) {
						current[k] = value;
					} else {
						current[k] = current[k] || {};
						current = current[k];
					}
				});
			});

			return data;
		}

	}

}