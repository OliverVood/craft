namespace Admin {

	export namespace DB {

		/**
		 * Работа с экземпляром БД структуры
		 */
		export class DBInstance {
			private readonly tables: { [key: string]: Table };
			private readonly keys: { primary: { [key: string]: Primary }, foreign: { [key: string]: Foreign } };
			private activeKey: Key | null;

			private $topTable: HTMLDivElement | null;

			constructor(data: DataDB, $structure: HTMLElement) {
				this.tables = {};
				this.keys = {primary: {}, foreign: {}};
				this.activeKey = null;
				this.$topTable = null;

				for (const table of data.tables) this.tables[table.name] = new globalThis.Admin.DB.Table(this, table, $structure);
				for (const table of data.tables) {
					for (const key of table.keys.primaries) this.keys.primary[key.name] = new globalThis.Admin.DB.Primary(this, this.tables[table.name], key.name, key.fields);
					for (const key of table.keys.foreigners) this.keys.foreign[key.name] = new globalThis.Admin.DB.Foreign(this, this.tables[table.name], key.name, key.fields, key.relationship_from, {
						table: this.tables[key.references_table],
						fields: key.references_fields,
						relationship: key.relationship_to
					});
				}
			}

			/**
			 * Обработчик наведения на элемент
			 * @param $table - Таблица на которую навели курсором
			 */
			public hoverElement($table: HTMLDivElement) {
				if (this.$topTable) this.$topTable.style.zIndex = '0';
				$table.style.zIndex = '1';
				this.$topTable = $table;
			}

			/**
			 * Запоминает активный кюч
			 * @param key
			 */
			public setActiveKey(key: Key) {
				this.activeKey = key;
			}

			/**
			 * Удаляет активный кюч
			 */
			public unsetActiveKey() {
				this.activeKey = null;
			}

			/**
			 * Устанавливает активный ключ
			 */
			public getActiveKey(): Key | null {
				return this.activeKey;
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