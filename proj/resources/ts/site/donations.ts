namespace Donations {

	export function index(data: { html: string }) {
		Common.Window.Create(data.html, 'Поддержать проект');
	}

}

(globalThis as any).Donations = Donations;