<?php

	declare(strict_types=1);

	namespace Base\Editor;

	use Base\Link\Right;

	/**
	 * Работа со ссылками через права пользователя в редакторе
	 */
	trait Link {
		public ?Right $access = null;
		public ?Right $select = null;
		public ?Right $browse = null;
		public ?Right $create = null;
		public ?Right $update = null;

		public ?Right $do_access = null;
		public ?Right $do_create = null;
		public ?Right $do_update = null;
		public ?Right $do_delete = null;
		public ?Right $set_state = null;

		/**
		 * Регистрация ссылок
		 * @return void
		 */
		protected function links(): void {
			$this->access = linkRight("{$this->feature->name()}_access", false);
			$this->select = linkRight("{$this->feature->name()}_select", false);
			$this->browse = linkRight("{$this->feature->name()}_browse", false);
			$this->create = linkRight("{$this->feature->name()}_create", false);
			$this->update = linkRight("{$this->feature->name()}_update", false);

			$this->do_access = linkRight("{$this->feature->name()}_do_access", false);
			$this->do_create = linkRight("{$this->feature->name()}_do_create", false);
			$this->do_update = linkRight("{$this->feature->name()}_do_update", false);
			$this->do_delete = linkRight("{$this->feature->name()}_do_delete", false);
			$this->set_state = linkRight("{$this->feature->name()}_set_state", false);
		}

	}