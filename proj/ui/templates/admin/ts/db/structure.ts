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
			$display							: HTMLAnchorElement | null = null;
			$name								: HTMLSpanElement | null = null;

			constructor(data: DataDB) {
				this.displayMode				= Structure.displayDescriptions;

				this.$structure					= document.querySelector('.view.dbs.structure > div') as HTMLDivElement;
				this.db 						= new DBInstance(data, this.$structure);

				this.renderPanel(data.name);
			}

			/**
			 * Отображение панели управления
			 * @param name - Название
			 * @private
			 */
			private renderPanel(name: string): void {
				this.$panel						= document.createElement('div'); this.$panel.className = 'panel';
				this.$display					= document.createElement('a'); this.$display.className = 'display';
				this.$name						= document.createElement('span');

				this.$name.innerText = `${name}:`;
				this.$display.setAttribute('title', 'Режим');

				this.renderDisplayMode();

				this.$structure.append(this.$panel);
				this.$panel.append(this.$name, this.$display);

				this.$display.addEventListener('click', () => this.switchDisplayMode());
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
						(this.$display as HTMLAnchorElement).innerText = 'Названия';
						break;
					case Structure.displayDescriptions:
						this.$structure.classList.remove('display_name');
						this.$structure.classList.add('display_description');
						(this.$display as HTMLAnchorElement).innerText = 'Описание';
						break;
				}
			}

		}

	}

}