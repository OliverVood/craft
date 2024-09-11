<?php

	namespace Base;

	abstract class ControllerAccess extends Controller {

		public function __construct(int $id) {
			parent::__construct($id);
		}

		/**
		 * Проверка права для контроллера
		 * @param int $right - Право
		 * @param int $id - Идентификатор экземпляра
		 * @return bool
		 */
		final public function allow(int $right, int $id = 0): bool {
			return Access::allow($right, $this->id, $id);
		}

	}