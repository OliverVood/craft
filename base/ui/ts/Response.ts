namespace Base {

	type TypeResponse 				= TypeResponseHistory | TypeResponseSection | TypeResponseDebugger;

	type TypeResponseGeneric<Type extends string, Data> = {
		type					: Type,
		data					: Data
	}

	type TypeResponseHistory		= TypeResponseGeneric<'history', TypeResponseHistoryData>;
	type TypeResponseSection		= TypeResponseGeneric<'section', TypeResponseSectionData>;
	type TypeResponseNotice			= TypeResponseGeneric<'notice', TypeResponseNoticeData>;
	type TypeResponseDebugger		= TypeResponseGeneric<'debugger', TypeResponseDebuggerData>;

	type TypeResponseHistoryData	= { address: string, xhr: string, handler: string };
	type TypeResponseSectionData	= { name: string, html: string, empty: boolean };
	type TypeResponseNoticeData		= { type: 'ok' | 'info' | 'error', notice: string };
	type TypeResponseDebuggerData	= any;

	type ResponseError =			{  notice?: string, data?: Record<string, string[]> };

	/**
	 * Ответы от сервера
	 */
	export class Response {

		/**
		 * Обрабатывает ошибки от сервера
		 * @param result - Результат переданный сервером
		 */
		public static error(result: ResponseError): void {
			if (result.notice) Notice.error(result.notice);
			Errors.execute(result.data || {});
		}

		/**
		 * Обработка ответа от сервера
		 * @param result - Результат переданный сервером
		 * @private
		 */
		public static run(result: any/*TypeResponse[]*/): void {
			if (result.sections) Response.sections(result.sections);
		}

		/**
		 * Разбирает тип ответа
		 * @param type - Тип ответа
		 * @param data - Данные
		 * @param handler - Обработчик
		 * @private
		 */
		private static execute(type: string, data: any, handler?: Function): void {
			switch (type) {
				case 'history': Response.history(data); break;
				// case 'section': Response.section(data); break;
				case 'notice': Response.notice(data); break;
				case 'data': Response.handler(handler, data); break;
				case 'errors': Response.errors(data); break;
				// case 'debugger': Debugger.append(data); break;
			}
		}

		/**
		 * Добавляет запись в историю браузера
		 * @param data - данные
		 * @private
		 */
		private static history(data: TypeResponseHistoryData): void {
			window.history.pushState({xhr: data.xhr, handler: data.handler}, '', data.address);
		}

		/**
		 * Добавляет контент в секции
		 * @param sections - Данные
		 * @private
		 */
		private static sections(sections: TypeResponseSectionData[]): void {
			for (const i in sections) {
				Base.Section.append(sections[i].name, sections[i].html, sections[i].empty);
			}
		}

		/**
		 * Генерирует уведомление
		 * @param data - Данные
		 * @private
		 */
		private static notice(data: TypeResponseNoticeData): void {
			Base.Notice.create(data.type, data.notice);
		}

		/**
		 * Запускает обработчик
		 * @param handler - Обработчик
		 * @param data - Данные
		 * @private
		 */
		private static handler(handler: Function | undefined, data: any): void {
			if (handler) handler(data);
		}

		/**
		 *
		 * @param data - Данные по ошибкам
		 * @private
		 */
		private static errors(data: Record<string, string[]>): void {
			Base.Errors.execute(data);
		}

	}

}