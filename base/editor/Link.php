<?php

	declare(strict_types=1);

	namespace Base\Editor;

	use Base\Link\Right;

	/**
	 * Работа со ссылками через права пользователя в редакторе
	 */
	trait Link {
		public ?Right $select = null;
//		public ?Right $browse = null;
		public ?Right $create = null;
		public ?Right $update = null;
//
		public ?Right $do_create = null;
		public ?Right $do_update = null;
		public ?Right $do_delete = null;
//		public ?Right $set_state = null;

		/**
		 * Регистрация ссылок
		 * @return void
		 */
		protected function links(): void {
			$this->select = linkRight("{$this->feature->name()}_select", false);
//			$this->regLinkBrowse();
			$this->create = linkRight("{$this->feature->name()}_create", false);
			$this->update = linkRight("{$this->feature->name()}_update", false);
//
			$this->do_create = linkRight("{$this->feature->name()}_do_create", false);
			$this->do_update = linkRight("{$this->feature->name()}_do_update", false);
			$this->do_delete = linkRight("{$this->feature->name()}_do_delete", false);
//			$this->regLinkSetState();
		}

//		protected function regLinkBrowse(): void { $this->browse = new LinkAccess($this->id, self::ACCESS_BROWSE, $this->name, 'browse', "/{$this->name}/browse?id=%id%", /* @lang JavaScript */"Base.Query.send('/{$this->name}/browse', {id: '%id%'}); return false;"); }
//
//		protected function regLinkSetState(): void { $this->set_state = new LinkAccess($this->id, self::ACCESS_STATE, $this->name, 'set_state', "/{$this->name}/set_state?id=%id%&state=%state%", /* @lang JavaScript */ "if (confirm('{$this->textSetStateConfirm}')) Base.Query.send('/{$this->name}/set_state', {id: '%id%', state: '%state%'}); return false;"); }

	}