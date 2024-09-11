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
	type TypeResponseSectionData	= { section: string, html: string, empty: boolean };
	type TypeResponseNoticeData		= { type: 'ok' | 'info' | 'error', notice: string };
	type TypeResponseDebuggerData	= any;

	/**
	 * Ответы от сервера
	 */
	export class Response {

		/**
		 * Запускает анализ ответа от сервера. Каждый xhr ответ должен проходить через данный класс.
		 * @param response - Тип ответа
		 * @param handler - Обработчик
		 * @private
		 */
		public static run(response: TypeResponse[], handler?: Function): void {
			for (const i in response) Response.execute(response[i].type, response[i].data, handler);
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
				case 'section': Response.section(data); break;
				case 'notice': Response.notice(data); break;
				case 'data': Response.handler(handler, data); break;
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
		 * Добавляет контент в секцию
		 * @param data - Данные
		 * @private
		 */
		private static section(data: TypeResponseSectionData): void {
			Base.Section.append(data.section, data.html, data.empty);
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

	}

}