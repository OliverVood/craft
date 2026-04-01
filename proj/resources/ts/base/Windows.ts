namespace Base {

	export namespace UI {

		export class Window {
			private static iter = 0;
			private static windows: Record<number, Window> = {};
			private static $windows: UIElement | null = null;
			private readonly id: number;

			private $instance : UIElement | null = null;

			public constructor(html: UIElement | string, title: string | null = null) {
				this.id = Window.iter++;

				this.initContainer();
				this.initWindow(html, title)

				Window.windows[this.id] = this;
			}

			private initContainer () {
				if (!Window.$windows) {
					Window.$windows = el('<div/>', {class: 'component window container'});

					el('body').append(Window.$windows);
				}
			}

			private initWindow(html: UIElement | string, title: string | null = null) {
				/* Elements */
				this.$instance = el('<div/>', {class: 'component window instance'});
				let $space = el('<div/>', {class: 'space'});
				let $content = el('<div/>', {class: 'component window content'});
				let $header = el('<div/>', {class: 'header'});
				let $title = el('<div/>', {class: 'title'});
				let $close = el('<div/>', {class: 'close'});
				let $main = el('<div/>', {class: 'main'});
				let $footer = el('<div/>', {class: 'footer'});

				/* Building DOM */
				(Window.$windows as UIElement).append(
					this.$instance.append(
						$space,
						$content.append(
							$header.append(
								$title,
								$close
							),
							$main,
							$footer
						)
					)
				);

				typeof html === 'string' ? $main.html(html as string) : $main.append(html);

				if (title !== null) $title.text(title);
				$content.addClass((title !== null) ? 'fill_title' : 'empty_title');

				/* Events */
				$space.on('click', () => this.Close());
				$close.on('click', () => this.Close());
			}

			public Close(): void {
				this.Remove();
			}

			private Remove(): void {
				this.$instance?.remove();
				Window.Delete(this.id);
			}

			static Delete(id: number): void {
				delete Window.windows[id];
			}

		}

	}

}

(typeof (globalThis as any).Base === 'undefined')
	? (globalThis as any).Base = Base
	: (
		typeof (globalThis as any).Base.UI === 'undefined'
			? (globalThis as any).Base.UI = Base.UI
			: Object.assign((globalThis as any).Base.UI, Base.UI)
	);
