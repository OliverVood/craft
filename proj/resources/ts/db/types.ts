namespace Admin {

	export namespace DB {

		export type DisplayNames						= 1;
		export type DisplayDescriptions					= 2;
		export type DisplayMode							= DisplayNames | DisplayDescriptions;

		export type DataDB								= { name: string, tables: DataTable[] };
		export type DataTable							= { name: string, description: string, params: DataTableParams, fields: DataField[], keys: DataKeys };
		export type DataField							= { type: string, name: string, description: string };
		export type DataKeys							= { primaries: DataKeyPrimary[], foreigners: DataKeyForeigner[] };
		export type DataKeyPrimary						= { type: 'primary', name: string, fields: string[] };
		export type DataKeyForeigner					= { type: 'foreign', name: string, fields: string[], references_table: string, references_fields: string[], relationship_from: DataRelationship, relationship_to: DataRelationship };
		export type DataTableParams						= { encoding: string, engine: string, collate: string };
		export type FataReferences						= { table: Table, fields: string[], relationship: DataRelationship };
		export type DataRelationship					=  1 | 2 | 3 | 4 | 5 | 6;

		}

	}