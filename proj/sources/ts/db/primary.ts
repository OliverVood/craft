namespace Admin {

	export namespace DB {

		/**
		 * Работа экземпляром первичного ключа структуры
		 */
		export class Primary extends globalThis.Admin.DB.Key {
			private table								: Table;
			private readonly fields						: string[] = [];

			constructor(db: DBInstance, table: Table, name: string, fields: string[]) {
				super(db, table, 'primary', name);

				this.table								= table;
				this.fields								= fields;
			}

			/**
			 * Отображение активного ключа
			 * @protected
			 */
			protected show() {
				for (const i in this.fields) this.table.fields[this.fields[i]].showPrimaryKey();
			}

			/**
			 * Скрытие активного ключа
			 * @protected
			 */
			protected hide(): void {
				for (const i in this.fields) this.table.fields[this.fields[i]].hidePrimaryKey();
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