type UICheckboxElement = Base.UI.Components.Checkbox;
type UIReportOkElement = Base.UI.Components.ReportOk;

namespace Base {

	export namespace UI {

		export namespace Components {

			export class Checkbox extends globalThis.Base.UI.Element {
				private active = false;

				public constructor(label: string = '', attrs?: UIElementAttributes) {
					super('<div/>', {class: 'component checkbox'});

					let $label = el('<label/>');
					let $input = el('<input/>', {type: 'checkbox'});
					let $div = el('<div/>');
					let $span = el('<span/>', {text: label});

					if (attrs) $input.setAttributes(attrs);

					$input.on('click', () => {
						this.active = !this.active;
						this.active ? this.addClass('active') : this.removeClass('active');
					});

					this.append(
						$label.append(
							$input,
							$div,
							$span
						)
					);
				}

				public change(callback: Function): Checkbox {
					this.on('change', () => {
						callback(this.active);
					});

					return this;
				}

			}

			export class Report extends globalThis.Base.UI.Element {
				public constructor(type: string, text: string) {
					super('<div/>', {class: `component report ${type}`});
					this.append(
						el('<div/>').text(text)
					);
				}

			}

			export class ReportOk extends Report {
				public constructor(text: string) {
					super('ok', text);
				}

			}

		}

	}

}

/**
 * Создаёт компонент checkbox
 * @param label - Текст надписи
 * @param attrs - Атрибуты
 */
function checkbox(label: string, attrs?: UIElementAttributes): UICheckboxElement {
	return new Base.UI.Components.Checkbox(label, attrs);
}

function reportOk(text: string): UIReportOkElement {
	return new Base.UI.Components.ReportOk(text);
}

(typeof (globalThis as any).Base === 'undefined')
	? (globalThis as any).Base = Base
	: (
		typeof (globalThis as any).Base.UI === 'undefined'
			? (globalThis as any).Base.UI = Base.UI
			: (
				typeof (globalThis as any).Base.UI.Components === 'undefined'
					? (globalThis as any).Base.UI.Components = Base.UI.Components
					: Object.assign((globalThis as any).Base.UI.Components, Base.UI.Components)
			)
	);

(globalThis as any).checkbox = checkbox;
(globalThis as any).reportOk = reportOk;