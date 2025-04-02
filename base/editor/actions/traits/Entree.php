<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions\Traits;

	/**
	 * Права доступа
	 */
	trait Entree {
		protected string $access;

		/**
		 * Проверяет права
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		private function allow(int $id = 0): bool {
			return $this->controller->allow($this->access, $id);
		}

	}