namespace Admin {

	export namespace DB {

		/**
		 * Работа экземпляром поля таблицы в структуре
		 */
		export class Field {
			private readonly $wrap						: HTMLDivElement;
			private readonly $type						: HTMLSpanElement;
			private readonly $name						: HTMLDivElement;
			private readonly $description				: HTMLDivElement;
			private readonly $key						: HTMLDivElement;

			static ER_RELATIONSHIP = {
				1: 'one',
				2: 'many',
				3: 'only_one',
				4: 'zero_or_one',
				5: 'one_or_many',
				6: 'zero_or_many'
			};

			constructor(data: DataField, $rows: HTMLDivElement) {
				this.$wrap								= document.createElement('div');
				this.$type								= document.createElement('span');
				this.$type.className					= 'type';
				this.$name								= document.createElement('div');
				this.$name.className					= 'name';
				this.$description						= document.createElement('div');
				this.$description.className				= 'description';
				this.$key								= document.createElement('div');
				this.$key.className						= 'key';

				this.$type.innerText					= data.type;
				this.$name.innerText					= data.name;
				this.$description.innerText				= data.description;

				this.$wrap.append(this.$type, this.$name, this.$description, this.$key);

				$rows.append(this.$wrap);
			}

			/**
			 * Отображает поле, как первичный ключ
			 */
			public showPrimaryKey(): void {
				this.$key.innerText = 'Pr';
				this.$wrap.classList.add('primary');
			}

			/**
			 * Скрывает поле, как первичный ключ
			 */
			public hidePrimaryKey(): void {
				this.$key.innerText = '';
				this.$wrap.classList.remove('primary');
			}

			/**
			 * Отображает поле, как внешний ключ
			 * @param relationship - Связь
			 */
			public showForeignKey(relationship: DataRelationship): void {
				this.$key.innerText = 'Fr';
				this.$wrap.classList.add('foreign', Field.ER_RELATIONSHIP[relationship]);
			}

			/**
			 * Отображает поле, как связанный внешний ключ
			 * @param relationship - Связь
			 */
			public showReferencesKey(relationship: DataRelationship): void {
				this.$key.innerText = '*';
				this.$wrap.classList.add('key', 'references', Field.ER_RELATIONSHIP[relationship]);
			}

			/**
			 * Скрывает поле, как внешний ключ
			 * @param relationship - Связь
			 */
			public hideForeignKey(relationship: DataRelationship): void {
				this.$key.innerText = '';
				this.$wrap.classList.remove('foreign', Field.ER_RELATIONSHIP[relationship]);
			}

			/**
			 * Скрывает поле, как связанный внешний ключ
			 * @param relationship - Связь
			 */
			public hideReferencesKey(relationship: DataRelationship): void {
				this.$key.innerText = '';
				this.$wrap.classList.remove('key', 'references', Field.ER_RELATIONSHIP[relationship]);
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