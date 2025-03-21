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

				Base.Request.data(state.xhr, {no_history: 1}/*, state.handler ? eval(state.handler) : null, {request: ''}*/).then(result => Base.Response.execute(result));
			});
		}

	}

}