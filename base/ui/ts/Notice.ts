namespace Base {

	export type TypeNotice						= 'ok' | 'error' | 'info';

	/**
	 * Пользовательские уведомления
	 */
	export class Notice {

		/* Variables */
		private static iter				: number = 0;
		private static notices			: {[key: number]: Instance} = {};

		/* Elements */
		public static $container		?: HTMLDivElement;

		/**
		 * Создаёт новое уведомление
		 * @param type - Тип уведомления
		 * @param html - Контент
		 */
		public static create(type: TypeNotice, html: string): Instance {
			return Notice.new(type, html);
		}

		/**
		 * Создаёт новое уведомление об успехе
		 * @param html - Контент
		 */
		public static ok(html: string): Instance {
			return Notice.new('ok', html);
		}

		/**
		 * Создаёт новое информативное уведомление
		 * @param html - Контент
		 */
		public static info(html: string): Instance {
			return Notice.new('info', html);
		}

		/**
		 * Создаёт новое уведомление об ошибке
		 * @param html - Контент
		 */
		public static error(html: string): Instance {
			return Notice.new('error', html);
		}

		/**
		 * Фабрика уведомлений
		 * @param type - Тип уведомления
		 * @param html - Контент
		 * @private
		 */
		private static new(type: TypeNotice, html: string): Instance {
			if (!Notice.$container) {
				Notice.$container = document.createElement('div');
				Notice.$container.classList.add('view', 'base', 'notices');
				document.body.append(Notice.$container);
			}

			Notice.iter++;
			let _notice = new Instance(Notice.iter, type, html);
			Notice.notices[Notice.iter] = _notice;

			return _notice;
		}

		/**
		 * Удаляет уведомление
		 * @param id - Идентификатор уведомления
		 */
		public static delete(id: number): void {
			delete Notice.notices[id];
		}

	}

	/**
	 * Экземпляр уведомления
	 */
	class Instance {
		/* Variables */
		id								: number;

		/* Elements */
		$wrap							: HTMLDivElement;

		/**
		 * Создаёт уведомление
		 * @param id - Идентификатор уведомления
		 * @param type - Тип уведомления
		 * @param html - Контент
		 */
		constructor(id: number, type: TypeNotice, html: string) {
			this.id		= id;

			/* Elements */
			this.$wrap = document.createElement('div'); this.$wrap.classList.add('instance', type);
			let $notice = document.createElement('div'); $notice.classList.add('notice');
			let $type = document.createElement('div'); $type.classList.add('type');
			let $close = document.createElement('div'); $close.classList.add('close');
			let $icon = document.createElement('div'); $close.classList.add('icon');

			/* Building DOM */
			(Notice.$container as HTMLDivElement).prepend(this.$wrap);
			this.$wrap.append($type, $notice, $close)
			$notice.append(html);
			$close.append($icon);

			/* Events */
			$close.addEventListener('click', () => { this.close(); });
		}

		/**
		 * Закрывает уведомление
		 */
		public close(): void {
			this.remove();
		}

		/**
		 * Удаляет уведомление
		 * @private
		 */
		private remove(): void {
			this.$wrap.remove();
			Notice.delete(this.id);
		}

	}

}