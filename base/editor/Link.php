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
			if (links()->check("{$this->feature->name()}_access")) $this->linkAccess = linkRight("{$this->feature->name()}_access");
			if (links()->check("{$this->feature->name()}_select")) $this->linkSelect = linkRight("{$this->feature->name()}_select");
			if (links()->check("{$this->feature->name()}_browse")) $this->linkBrowse = linkRight("{$this->feature->name()}_browse");
			if (links()->check("{$this->feature->name()}_create")) $this->linkCreate = linkRight("{$this->feature->name()}_create");
			if (links()->check("{$this->feature->name()}_update")) $this->linkUpdate = linkRight("{$this->feature->name()}_update");

			if (links()->check("{$this->feature->name()}_do_access")) $this->linkDoAccess = linkRight("{$this->feature->name()}_do_access");
			if (links()->check("{$this->feature->name()}_do_create")) $this->linkDoCreate = linkRight("{$this->feature->name()}_do_create");
			if (links()->check("{$this->feature->name()}_do_update")) $this->linkDoUpdate = linkRight("{$this->feature->name()}_do_update");
			if (links()->check("{$this->feature->name()}_do_delete")) $this->linkDoDelete = linkRight("{$this->feature->name()}_do_delete");
			if (links()->check("{$this->feature->name()}_set_state")) $this->linkSetState = linkRight("{$this->feature->name()}_set_state");
		}

	}