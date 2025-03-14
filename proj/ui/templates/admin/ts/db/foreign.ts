///<reference path="key.ts"/>

namespace Admin {

	export namespace DB {

		/**
		 * Работа экземпляром внешнего ключа структуры
		 */
		export class Foreign extends Key {
			private table								: Table;
			private readonly fields						: string[] = [];
			private readonly relationship				: DataRelationship;
			private references							: FataReferences;

			constructor(db: DBInstance, table: Table, name: string, fields: string[], relationship: DataRelationship, references: FataReferences) {
				super(db, table, 'foreign', name);

				this.table 								= table;
				this.fields								= fields;
				this.relationship						= relationship;
				this.references							= references;
			}

			/**
			 * Отображение активного ключа
			 * @protected
			 */
			protected show(): void {
				for (const i in this.fields) this.table.fields[this.fields[i]].showForeignKey(this.relationship);
				for (const i in this.references.fields) this.references.table.fields[this.references.fields[i]].showReferencesKey(this.references.relationship);
			}

			/**
			 * Скрытие активного ключа
			 * @protected
			 */
			protected hide(): void {
				for (const i in this.fields) this.table.fields[this.fields[i]].hideForeignKey(this.relationship);
				for (const i in this.references.fields) this.references.table.fields[this.references.fields[i]].hideReferencesKey(this.references.relationship);
			}

		}

	}

}