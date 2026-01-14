namespace Base {

	/**
	 * Работает с историей браузера
	 */
	export class History {

		/**
		 * Запускает отслеживание истории браузера
		 */
		public static Initialization() {
			window.addEventListener('popstate', event  => {
				let state = event.state;

				if (!state) return;

				console.log(state.xhr);
				const url = new URL(`http://temp.local/${state.xhr}`);
				const searchParams = url.searchParams;
				searchParams.append('no_history', '1');

				Base.Request.data(`${url.pathname}${url.search}`.substring(1), {no_history: 1}, {method: 'get'}/*, state.handler ? eval(state.handler) : null, {request: ''}*/).then(result => globalThis.Base.Response.execute(result));
			});
		}

	}

}

(typeof (globalThis as any).Base === 'undefined')
	? (globalThis as any).Base = Base
	: Object.assign((globalThis as any).Base, Base);