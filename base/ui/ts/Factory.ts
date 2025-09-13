namespace Base {

	export namespace UI {

		/**
		 * Фабрика элементов
		 */
		export class Factory {
			private static instance: Factory;

			private constructor() {  }

			/**
			 * Возвращает экземпляр фабрики
			 */
			public static getInstance(): Factory {
				if (!this.instance) this.instance = new Factory();

				return this.instance;
			}

			/**
			 * Создаёт элемент
			 * @param tag - Тег
			 * @param $attributes - Атрибуты
			 */
			public create(tag: HTMLElement | string, $attributes?: TypeElementAttributes): Element {
				return new Element(tag, $attributes);
			}

		}

	}

}