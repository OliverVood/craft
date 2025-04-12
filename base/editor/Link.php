<?php

	declare(strict_types=1);

	namespace Base\Editor;

	use Base\Link\Right;

	/**
	 * Работа со ссылками через права пользователя в редакторе
	 */
	trait Link {
		public ?Right $linkAccess = null;
		public ?Right $linkSelect = null;
		public ?Right $linkBrowse = null;
		public ?Right $linkCreate = null;
		public ?Right $linkUpdate = null;

		public ?Right $linkDoAccess = null;
		public ?Right $linkDoCreate = null;
		public ?Right $linkDoUpdate = null;
		public ?Right $linkDoDelete = null;
		public ?Right $linkSetState = null;

		/**
		 * Регистрация ссылок
		 * @return void
		 */
		protected function links(): void {
			$this->linkAccess = linkRight("{$this->feature->name()}_access", false);
			$this->linkSelect = linkRight("{$this->feature->name()}_select", false);
			$this->linkBrowse = linkRight("{$this->feature->name()}_browse", false);
			$this->linkCreate = linkRight("{$this->feature->name()}_create", false);
			$this->linkUpdate = linkRight("{$this->feature->name()}_update", false);

			$this->linkDoAccess = linkRight("{$this->feature->name()}_do_access", false);
			$this->linkDoCreate = linkRight("{$this->feature->name()}_do_create", false);
			$this->linkDoUpdate = linkRight("{$this->feature->name()}_do_update", false);
			$this->linkDoDelete = linkRight("{$this->feature->name()}_do_delete", false);
			$this->linkSetState = linkRight("{$this->feature->name()}_set_state", false);
		}

	}