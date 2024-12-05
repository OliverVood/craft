<?php

	namespace Base\Editor;

	use Base\Link\Right as LinkAccess;

	/**
	 * Работа со ссылками через права пользователя в редакторе
	 */
	trait Link {
		public LinkAccess $select;
		public LinkAccess $browse;
		public LinkAccess $create;
		public LinkAccess $update;

		public LinkAccess $do_create;
		public LinkAccess $do_update;
		public LinkAccess $do_delete;
		public LinkAccess $set_state;

		/**
		 * Регистрация ссылок
		 * @return void
		 */
		protected function regLinks(): void {
			$this->regLinkSelect();
			$this->regLinkBrowse();
			$this->regLinkCreate();
			$this->regLinkUpdate();

			$this->regLinkDoCreate();
			$this->regLinkDoUpdate();
			$this->regLinkDoDelete();
			$this->regLinkSetState();
		}

		protected function regLinkSelect(): void { $this->select = new LinkAccess($this->id, self::ACCESS_SELECT, $this->name, 'select', "/{$this->name}/select?page=%page%", /* @lang JavaScript */"Base.Query.send('/{$this->name}/select', {page: '%page%'}); return false;"); }
		protected function regLinkBrowse(): void { $this->browse = new LinkAccess($this->id, self::ACCESS_BROWSE, $this->name, 'browse', "/{$this->name}/browse?id=%id%", /* @lang JavaScript */"Base.Query.send('/{$this->name}/browse', {id: '%id%'}); return false;"); }
		protected function regLinkCreate(): void { $this->create = new LinkAccess($this->id, self::ACCESS_CREATE, $this->name, 'create', 'default', /* @lang JavaScript */"Base.Query.send('/{$this->name}/create'); return false;"); }
		protected function regLinkUpdate(): void { $this->update = new LinkAccess($this->id, self::ACCESS_UPDATE, $this->name, 'update', "/{$this->name}/update?id=%id%", /* @lang JavaScript */"Base.Query.send('/{$this->name}/update', {id: '%id%'}); return false;"); }

		protected function regLinkDoCreate(): void { $this->do_create = new LinkAccess($this->id, self::ACCESS_CREATE, $this->name, 'do_create', 'default', /* @lang JavaScript */ "Base.Query.submitForm(this); return false;"); }
		protected function regLinkDoUpdate(): void { $this->do_update = new LinkAccess($this->id, self::ACCESS_UPDATE, $this->name, 'do_update', "/{$this->name}/do_update?id=%id%", /* @lang JavaScript */ "Base.Query.submitForm(this); return false;"); }
		protected function regLinkDoDelete(): void { $this->do_delete = new LinkAccess($this->id, self::ACCESS_DELETE, $this->name, 'do_delete', "/{$this->name}/do_delete?id=%id%", /* @lang JavaScript */ "if (confirm('" . __($this->textDeleteConfirm) . "')) Base.Query.send('/{$this->name}/do_delete', {id: '%id%'}); return false;"); }
		protected function regLinkSetState(): void { $this->set_state = new LinkAccess($this->id, self::ACCESS_STATE, $this->name, 'set_state', "/{$this->name}/set_state?id=%id%&state=%state%", /* @lang JavaScript */ "if (confirm('{$this->textSetStateConfirm}')) Base.Query.send('/{$this->name}/set_state', {id: '%id%', state: '%state%'}); return false;"); }

	}