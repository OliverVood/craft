namespace Admin {

	export namespace DB {

		type DataDB								= { name: string, tables: DataTable[] };
		type DataTable							= { name: string, description: string, params: DataTableParams, fields: DataField[], keys: DataKeys };
		type DataField							= { name: string, type: string, description: string };
		type DataKeys							= { primaries: DataKeyPrimary[], foreigners: DataKeyForeigner[] };
		type DataKeyPrimary						= { type: 'primary', name: string, fields: string[] };
		type DataKeyForeigner					= { type: 'foreign', name: string, fields: string[], references_table: string, references_fields: string[], relationship_from: number, relationship_to: number };
		type DataTableParams					= { encoding: string, engine: string };

		export class Structure {//TODO Перебрать классы для структуры БД
			db									: DB;

			$structure							: HTMLDivElement;
			$panel								: HTMLDivElement | null = null;
			$display							: HTMLAnchorElement | null = null;

			constructor(data: DataDB) {
				console.log(data);
				this.$structure					= document.getElementById('structure') as HTMLDivElement;
				this.db 						= new DB(data, this.$structure, this);

				this.RenderPanel();
			}

			private RenderPanel(): void {
				this.$panel						= document.createElement('div'); this.$panel.className = 'panel';
				this.$display					= document.createElement('a'); this.$display.className = 'display';

				this.$structure.append(this.$panel);
				this.$panel.append(this.$display);
			}

		}

		class DB {
			private readonly tables				: {[key: string]: Table};
			private activeKey					: Key | null;

			constructor(data: DataDB, $structure: HTMLElement, structure: Structure) {
				this.tables						= {};
				this.activeKey					= null;

				for (const table of data.tables) this.tables[table.name] = new Table(/*table, $structure, structure*/);
			}
		}

		class Table {}

		class Field {}

		class Key {}

		class Primary extends Key {}

		class Foreign extends Key {}

	}

}