<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Промежуточное программное обеспечение для маршрутизаторов
	 */
	abstract class Middleware {
		/**
		 * Выполняется перед выполнением контроллера
		 * @return void
		 */
		abstract public function inlet(): void;

		/**
		 * Выполняется после выполнения контроллера
		 * @return void
		 */
		abstract public function outlet(): void;

	}