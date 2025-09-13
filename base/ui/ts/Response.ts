namespace Base {

	type ResponseSuccess			= { history?: ResponseHistory, sections?: ResponseSection[], notices?: ResponseNotice[], debugger?: ResponseDebugger };
	type ResponseError				= { notices?: ResponseNotice[], data?: ResponseErrorData };
	type ResponseErrorData			= Record<string, string[]>;

	type ResponseHistory			= { address: string, xhr: string };
	type ResponseSection			= { name: string, html: string, empty: boolean };
	type ResponseNotice				= { type: TypeNotice, text: string, data?: ResponseErrorData };
	type ResponseDebugger			= DebuggerData;

	/**
	 * Ответы от сервера
	 */
	export class Response {

		/**
		 * Обработка успешного ответа от сервера
		 * @param result - Результат переданный сервером
		 * @private
		 */
		public static execute(result: ResponseSuccess): void {
			if (result.sections) Response.sections(result.sections);
			if (result.history) Response.history(result.history);
			if (result.notices) Response.notices(result.notices);
			if (result.debugger) Response.debugger(result.debugger);
		}

		/**
		 * Обрабатывает ошибки от сервера
		 * @param result - Результат переданный сервером
		 */
		public static error(result: ResponseError): void {
			if (result.notices) Response.notices(result.notices);
			Errors.execute(result.data || {});
		}

		/**
		 * Добавляет запись в историю браузера
		 * @param data - данные
		 * @private
		 */
		private static history(data: ResponseHistory): void {
			window.history.pushState({xhr: data.xhr}, '', data.address);
		}

		/**
		 * Добавляет контент в секции
		 * @param sections - Данные
		 * @private
		 */
		private static sections(sections: ResponseSection[]): void {
			for (const i in sections) {
				Base.Section.append(sections[i].name, sections[i].html, sections[i].empty);
			}
		}

		/**
		 * Генерирует уведомления
		 * @param notices - Уведомления
		 * @private
		 */
		public static notices(notices: ResponseNotice[]): void {
			Errors.clear();

			for (const i in notices) {
				Base.Notice.create(notices[i].type, notices[i].text);
				if (notices[i].data) Errors.execute(notices[i].data || {}, false);
			}
		}

		/**
		 * Добавляет данные в отладчик
		 * @param data - Данные
		 */
		public static debugger(data: ResponseDebugger): void {
			Debugger.getInstance().append(data);
		}

	}

}