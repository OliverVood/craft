namespace Base {

	// type TypeResponse 				= TypeResponseHistory | TypeResponseSection | TypeResponseDebugger;
	//
	// type TypeResponseGeneric<Type extends string, Data> = {
	// 	type					: Type,
	// 	data					: Data
	// }

	// type TypeResponseHistory		= TypeResponseGeneric<'history', TypeResponseHistoryData>;
	// type TypeResponseSection		= TypeResponseGeneric<'section', TypeResponseSectionData>;
	// type TypeResponseNotice			= TypeResponseGeneric<'notice', TypeResponseNoticeData>;
	// type TypeResponseDebugger		= TypeResponseGeneric<'debugger', TypeResponseDebuggerData>;

	type ResponseSuccess			= { history?: ResponseHistory, sections?: ResponseSection[], notices?: ResponseNotice[] };
	type ResponseError				= { notices?: ResponseNotice[], data?: ResponseErrorData };
	type ResponseErrorData			= Record<string, string[]>;

	type ResponseHistory			= { address: string, xhr: string/*, handler: string*/ };
	type ResponseSection			= { name: string, html: string, empty: boolean };
	type ResponseNotice				= { type: TypeNotice, text: string, data?: ResponseErrorData };
	// type TypeResponseNoticeData		= { type: 'ok' | 'info' | 'error', notice: string };
	// type TypeResponseDebuggerData	= any;

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
			// case 'data': Response.handler(handler, data); break;
			// case 'errors': Response.errors(data); break;
			// case 'debugger': Debugger.append(data); break;
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
			window.history.pushState({xhr: data.xhr/*, handler: data.handler*/}, '', data.address);
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

		// /**
		//  * Запускает обработчик
		//  * @param handler - Обработчик
		//  * @param data - Данные
		//  * @private
		//  */
		// private static handler(handler: Function | undefined, data: any): void {
		// 	if (handler) handler(data);
		// }
		//
		// /**
		//  *
		//  * @param data - Данные по ошибкам
		//  * @private
		//  */
		// private static errors(data: Record<string, string[]>): void {
		// 	Base.Errors.execute(data);
		// }

	}

}