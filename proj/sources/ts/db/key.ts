namespace Admin {

	export namespace DB {

		/**
		 * Работа ключами структуры
		 */
		export class Key {
			protected db: DBInstance;

			protected type: string;
			protected name: string;

			protected display: boolean;

			protected $key: HTMLDivElement;

			protected constructor(db: DBInstance, table: Table, type: string, name: string) {
				this.db = db;
				this.type = type;
				this.name = name;

				this.display = false

				this.$key = this.appendKey(this.type, this.name, table);
			}

			/**
			 * Отображение ключа
			 * @param type - Тип
			 * @param name - Наименование
			 * @param table - Таблица
			 * @private
			 */
			private appendKey(type: string, name: string, table: Table): HTMLDivElement {
				let $wrap = document.createElement('div');
				let $type = document.createElement('div');
				$type.className = 'type';
				$type.innerText = type;
				let $name = document.createElement('div');
				$name.className = 'name';
				$name.innerText = name;

				$wrap.append($type, $name);
				table.appendKey($wrap);

				$wrap.addEventListener('click', () => {
					this.setDisplay();
				});

				return $wrap;
			}

			/**
			 * Отображение / скрытие активного ключа
			 */
			public setDisplay(): void {
				this.display ? this.setDeactivate() : this.setActivate();
			}

			/**
			 * Отображение активного ключа
			 * @private
			 */
			private setActivate(): void {
				this.db.getActiveKey()?.setDeactivate();
				this.db.setActiveKey(this);

				this.show();
				this.$key.classList.add('active');
				this.display = true;
			}

			/**
			 * Скрытие активного ключа
			 * @private
			 */
			private setDeactivate(): void {
				this.db.unsetActiveKey();

				this.hide();
				this.$key.classList.remove('active');
				this.display = false;
			}

			/**
			 * Отображение активного ключа
			 * @protected
			 */
			protected show(): void {
			}

			/**
			 * Скрытие активного ключа
			 * @protected
			 */
			protected hide(): void {
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
	);