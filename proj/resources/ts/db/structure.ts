namespace Admin {

	export namespace DB {

		/**
		 * Работа со структурой БД
		 */
		export class Structure {
			static displayNames					: DisplayNames = 1;
			static displayDescriptions			: DisplayDescriptions = 2;

			db									: DBInstance;
			displayMode							: DisplayMode;

			$structure							: HTMLDivElement;
			$panel								: HTMLDivElement | null = null;
			$displayValue						: HTMLAnchorElement | null = null;

			constructor(data: DataDB) {
				this.displayMode				= Structure.displayDescriptions;

				this.$structure					= document.querySelector('.view.db.structure > div') as HTMLDivElement;
				this.db 						= new globalThis.Admin.DB.DBInstance(data, this.$structure);

				this.renderPanel(data.name);
			}

			/**
			 * Отображение панели управления
			 * @param name - Название
			 * @private
			 */
			private renderPanel(name: string): void {
				this.$panel						= document.createElement('div'); this.$panel.className = 'panel';

				let $coverName = document.createElement('div');
				let $nameKey = document.createElement('span');
				let $nameValue = document.createElement('span');
				$nameKey.innerText = __('БД');
				$nameValue.innerText = name;

				let $coverDisplay = document.createElement('div');
				let $displayKey = document.createElement('span');
				this.$displayValue = document.createElement('a');
				$displayKey.innerText = __('Отображать');
				this.$displayValue.className = 'display';


				this.renderDisplayMode();

				this.$structure.append(this.$panel);
				$coverName.append($nameKey, $nameValue);
				$coverDisplay.append($displayKey, this.$displayValue)
				this.$panel.append($coverName, $coverDisplay);

				this.$displayValue.addEventListener('click', () => this.switchDisplayMode());
			}

			/**
			 * Переключение режима отображения
			 * @private
			 */
			private switchDisplayMode(): void {
				if (this.displayMode === Structure.displayNames) {
					this.displayMode = Structure.displayDescriptions;
				} else {
					this.displayMode = Structure.displayNames;
				}

				this.renderDisplayMode();
			}

			/**
			 * Отображение режима отображения
			 * @private
			 */
			private renderDisplayMode(): void {
				switch (this.displayMode) {
					case Structure.displayNames:
						this.$structure.classList.remove('display_description');
						this.$structure.classList.add('display_name');
						(this.$displayValue as HTMLAnchorElement).innerText = __('Названия');
						break;
					case Structure.displayDescriptions:
						this.$structure.classList.remove('display_name');
						this.$structure.classList.add('display_description');
						(this.$displayValue as HTMLAnchorElement).innerText = __('Описание');
						break;
				}
			}

		}

	}

}

(typeof (globalThis as any).Admin === 'undefined')
	? (globalThis as any).Admin = Admin
	: (
		typeof (globalThis as any).Admin.DB === 'undefined'
			? (globalThis as any).Admin.DB = Admin.DB
			: Object.assign((globalThis as any).Admin.DB, Admin.DB)
	)