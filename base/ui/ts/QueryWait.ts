namespace Base {

	type TypeRequestOptionsMethod 		= 'get' | 'post' | 'delete' | 'patch' | 'put';
	type TypeRequestOptionsCache		= 'default' | 'force-cache' | 'no-cache' | 'no-store' | 'only-if-cached' | 'reload';
	type TypeRequestOptionsCredentials	= 'include' | 'omit' | 'same-origin' | undefined
	type TypeRequestFormat				= 'json' | 'form_data';
	type TypeRequestData				= FormData | string;
	type TypeObj						=  { [key: string]: string | null | TypeObj };

	type TypeRequestOptions = {
		method							?: TypeRequestOptionsMethod,
		cache							?: TypeRequestOptionsCache,
		credentials						?: TypeRequestOptionsCredentials
		format							?: TypeRequestFormat
	}

	/**
	 * Асинхронные XHR запросы
	 */
	export class QueryWait {

		/**
		 * Отправляет данных в виде JSON
		 * @param url - Адрес
		 * @param data - Данные
		 * @param options - Опции
		 */
		public static sendJSON(url: string, data: Object, options?: TypeRequestOptions): Promise<any> {
			let json = QueryWait.objectToJSON(data);

			return QueryWait.XHR('json', url, json, options);
		}

		/**
		 * Отправляет форму
		 * @param $form - Форма
		 * @param options - Опции
		 */
		public static sendForm($form: Element, options?: TypeRequestOptions): Promise<any> {
			let url = $form.getAttribute('action') as string;
			let data = QueryWait.formToDataForm($form);

			return QueryWait.XHR('form_data', url, data, options);
		}

		/**
		 * Отправляет форму преобразовав данные в JSON
		 * @param $form - Форма
		 * @param options - Опции
		 */
		public static sendFormJSON($form: Element, options?: TypeRequestOptions): Promise<any> {
			let url = $form.getAttribute('action') as string;
			let formData =  QueryWait.formToDataForm($form);
			let data = QueryWait.getDataFormToJSON(formData);

			return QueryWait.sendJSON(url, data, options);
		}

		/**
		 * Отправляет запрос
		 * @param format - Формат
		 * @param url - Адрес
		 * @param data - Данные
		 * @param options - Опции
		 * @private
		 */
		private static async XHR(format: TypeRequestFormat, url: string, data: TypeRequestData, options?: TypeRequestOptions): Promise<any> {
			let response = await fetch(url, QueryWait.prepareData(format, data, options));
			let result = await response.json();
			Response.run(result);
			for (const item of result) if (item.type == 'data') return item.data
		}

		/**
		 * Подготавливает данные для отправки
		 * @param format - Формат
		 * @param data - Данные
		 * @param options - Опции
		 * @private
		 */
		private static prepareData(format: TypeRequestFormat, data: TypeRequestData, options?: TypeRequestOptions): RequestInit {
			let method			: TypeRequestOptionsMethod			= 'post';
			let cache			: TypeRequestOptionsCache			= 'no-cache';
			let credentials		: TypeRequestOptionsCredentials		= 'include';

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

			if (options?.method == 'get') return init;

			if (format === 'json') init['headers'] = {'Content-Type': 'application/json'};

			init['body'] = data;

			return init;
		}

		/**
		 * Преобразует объект в JSON
		 * @param data - Данные
		 * @private
		 */
		private static objectToJSON(data: Object): string {
			return JSON.stringify(data);
		}

		/**
		 * Возвращает данные из формы
		 * @param $form - Форма
		 * @private
		 */
		private static formToDataForm($form: Element): FormData {
			return new FormData($form.html() as HTMLFormElement);
		}

		/**
		 * Возвращает объект полученный из данных формы
		 * @param data - Данные
		 * @private
		 */
		private static getDataFormToJSON(data: FormData): TypeObj {
			let obj: TypeObj = {};
			data.forEach((formDataValue, formDateKey) => {
				let keys, value;
				[keys, value] = formDateKey.endsWith('[]') ? [formDateKey.slice(0, -2), data.getAll(formDateKey)] : [formDateKey, data.get(formDateKey)];
				let pieces = (keys as string).split('[').map((piece) => { return piece.replace(']', ''); });
				let nesting = pieces.length;
				let link = obj;
				for (const i in pieces) {
					if (+i < nesting - 1) {
						if (link[pieces[i]] === undefined) link[pieces[i]] = {};
						link = link[pieces[i]] as TypeObj;
					} else {
						link[pieces[i]] = value as string;
					}
				}
			});
			return obj;
		}

	}

}