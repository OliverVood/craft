namespace Skins {

	import Element = Base.UI.Element;

	export class Select {
		/* Variables */
		open									: boolean;
		closing									: boolean;

		/* Elements */
		private readonly $elem					: Element;
		private readonly $skin					: Element;
		private readonly $placeholder			: Element;
		private readonly $content				: Element;
		private readonly funcDelete				: Function | null;
		private readonly data					: Object;

		constructor(elem: Element, funcDelete: Function | null = null, data: Object = {}) {
			/* Set variables */
			this.open			= false;
			this.closing		= true;
			this.funcDelete		= funcDelete;
			this.data			= data;

			/* Set elements */
			this.$elem = elem;
			this.$skin = el('<div/>', {tabindex: 0, class: 'skin select'});
			this.$placeholder = el('<div/>', {class: 'placeholder'});
			this.$content = el('<div/>', {class: 'content'});

			/* Events */
			this.$skin.on('click', this.OnSkin.bind(this));
			this.$placeholder.on('click', this.Switch.bind(this));
			el(document.body).on('click', this.OnDocument.bind(this));

			this.ScanElem(this.$elem, this.$content, this.funcDelete, this.data);

			this.$elem.hide();

			this.$skin.append(
				this.$placeholder,
				this.$content
			);

			this.$elem.insertAfter(this.$skin);

			let observer = new MutationObserver(this.Restructure.bind(this));

			observer.observe(this.$elem.getHtml(), {childList: true});
		}

		private Restructure(record: MutationRecord[], obs: MutationObserver): void {
			this.$content.empty();
			this.$placeholder.text('Выберите');
			this.ScanElem(this.$elem, this.$content, this.funcDelete, this.data);
			console.log(record, obs);
		}

		private OnSkin(): void {
			this.closing = false;
		}

		private OnDocument(): void {
			if (this.closing) this.Close();
			this.closing = true;
		}

		private Switch(): void {
			switch (this.open) {
				case true: this.Close(); break;
				case false: this.Open(); break;
			}
		}

		private Open(): void {
			this.$skin.addClass('open');
			this.open = true;
		}

		private Close(): void {
			this.$skin.removeClass('open');
			this.open = false;
		}

		private ScanElem($elem: Element, $parent: Element, funcDelete: Function | null, data: Object = {}): void {
			let self = this;

			let children = $elem.children();
			for (const child of children) {
				switch (child.prop('nodeName')) {
					case 'OPTION': self.RenderOption(child, $parent, funcDelete, data); break;
					case 'OPTGROUP': self.RenderOptgroup(child, $parent, funcDelete, data); break;
				}
			}
		}

		private RenderOption($elem: Element, $parent: Element, funcDelete: Function | null, data: Object = {}): void {
			/* Variables */
			let text = $elem.getText();
			let value = $elem.attr('value');
			let selected = ($elem.is('selected')) ? ' selected' : '';
			let disabled = ($elem.is('disabled')) ? ' disabled' : '';
			let hidden = ($elem.is('disabled')) ? ' hidden' : '';

			/* Elements */
			let $option = el('<div/>', {class: `option${selected}${disabled}${hidden}`});
			let $select = el('<div/>', {class: 'select'});
			let $delete = el('<div/>', {class: 'delete'});

			if ($elem.is('selected')) this.$placeholder.text(text);

			/* Building DOM */
			$option.append(
				$select,
				funcDelete ? $delete : null
			);

			/* Events */
			$select.on('click', () => {
				$elem.prop('selected', true);
				$elem.trigger('change');
				this.$content.children().removeClass('selected');
				$option.addClass('selected');
				this.$placeholder.text(text);
				this.Close();
			});
			if (funcDelete) $delete.on('click', () => funcDelete(Number(value), data));

			$select.text(text);

			$parent.append($option);
		}

		private RenderOptgroup($elem: Element, $parent: Element, funcDelete: Function | null, data: Object = {}): void {
			let label = $elem.attr('label') as string;

			let $optgroup = el('<div/>', {class: 'optgroup'});
			let $label = el('<div/>', {class: 'label'});
			let $content = el('<div/>', {class: 'content'});

			this.ScanElem($elem, $content, funcDelete, data);

			$optgroup.append(
				$label.text(label),
				$content
			);

			$parent.append($optgroup);
		}

	}

}

(typeof (globalThis as any).Skins === 'undefined')
	? (globalThis as any).Skins = Skins
	: Object.assign((globalThis as any).Skins, Skins);