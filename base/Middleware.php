<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Промежуточное программное обеспечение для маршрутизаторов
	 */
	abstract class Middleware {
		/**
		 * Выполняется перед выполнением контроллера
		 * @return bool
		 */
		abstract public function inlet(): bool;

		/**
		 * Выполняется после выполнения контроллера
		 * @return bool
		 */
		abstract public function outlet(): bool;

	}