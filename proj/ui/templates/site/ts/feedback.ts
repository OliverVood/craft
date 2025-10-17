namespace Feedback {
	let wind: Common.UIWindow | null = null;

	/**
	 * Отображение формы обратной связи
	 * @param data
	 */
	export function show(data: { html: string }): void {
		wind = Common.Window.Create(data.html, 'Обратная связь');
	}

	/**
	 * Выполняется после отправки формы обратной связи
	 */
	export function afterSend(): void {
		(wind as Common.UIWindow).Close();
		Base.Notice.ok('Ваша заявка принята')
	}

}