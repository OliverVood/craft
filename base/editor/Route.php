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

			BaseRoute::set("{$this->name}::select", "{$this->pathController}::select", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::browse", "{$this->pathController}::browse", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::create", "{$this->pathController}::create", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::update", "{$this->pathController}::update", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::delete", "{$this->pathController}::delete", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_create", "{$this->pathController}::doCreate", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_update", "{$this->pathController}::doUpdate", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_delete", "{$this->pathController}::doDelete", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::set_state", "{$this->pathController}::setState", BaseRoute::SOURCE_EDITORS);
		}

	}