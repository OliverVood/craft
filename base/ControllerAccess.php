<?php

	declare(strict_types=1);

	namespace Base;

	use Base\Access\Feature;

	/**
	 * Базовый класс для работы с контроллерами с учётом прав доступа
	 */
	abstract class ControllerAccess extends Controller {
		protected Feature $feature;

		/**
		 * @param Feature $feature - Экземпляр признака
		 */
		public function __construct(Feature $feature) {
			parent::__construct();

			$this->feature = $feature;
		}

		/**
		 * Проверка права для контроллера
		 * @param string $right - Название права
		 * @param int $id - Идентификатор экземпляра
		 * @return bool
		 */
		final public function allow(string $right, int $id = 0): bool {
			return app()->access->allow($this->feature->id(), $this->feature->rights($right)->id(), $id);
		}

	}