<?php

	namespace Base\Editor;

	use Base\Route as BaseRoute;

	/**
	 * Маршрутизатор редактора
	 */
	trait Route {

		/**
		 * Регистрация маршрутов
		 * @return void
		 */
		protected function regRoutes(): void {
			if (POINTER != 'xhr') return;

			BaseRoute::set("{$this->name}::select", "{$this->nameController}::select", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::browse", "{$this->nameController}::browse", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::create", "{$this->nameController}::create", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::update", "{$this->nameController}::update", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::delete", "{$this->nameController}::delete", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_create", "{$this->nameController}::doCreate", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_update", "{$this->nameController}::doUpdate", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_delete", "{$this->nameController}::doDelete", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::set_state", "{$this->nameController}::setState", BaseRoute::SOURCE_EDITORS);
		}

	}