namespace Base {

	/**
	 * Глобальные параметры
	 */
	export class GlobalParams {
		private static param: {[key: string]: any} = {};

		/**
		 * Устанавливает параметр
		 * @param name - Наименование параметра
		 * @param value - Значение параметра
		 */
		public static set(name: string, value: any) {
			GlobalParams.param[name] = value;
		}

		/**
		 * Возвращает параметр
		 * @param name - Наименование параметра
		 */
		public static get(name: string): any {
			return GlobalParams.param[name];
		}

	}

}

(typeof (globalThis as any).Base === 'undefined')
	? (globalThis as any).Base = Base
	: Object.assign((globalThis as any).Base, Base);