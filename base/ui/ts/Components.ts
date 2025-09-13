/// <reference path="./Element.ts" />

type UICheckboxElement = Base.UI.Components.Checkbox;

namespace Base {

	export namespace UI {

		export namespace Components {

			export class Checkbox extends Base.UI.Element {
				private active = false;

				public constructor(label: string = '') {
					super('div', {class: 'component checkbox'});

					let $label = el('label');
					let $input = el('input', {type: 'checkbox'});
					let $div = el('div');
					let $span = el('span', {text: label});

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

		}

	}

}