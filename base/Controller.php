<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Базовый класс контроллеров
	 */
	abstract class Controller {
		protected int $id;

		/**
		 * @param int $id - Идентификатор признака
		 */
		public function __construct(int $id) {
			$this->id = $id;
		}

//		/**
//		 * Возвращает модель
//		 * @param string $name - Наименование модели
//		 * @return Model
//		 */
//		public function model(string $name): Model {
//			return Model::get($name);
//		}
//
//		/**
//		 * Проверяет права
//		 * @param int $right - Право
//		 * @param int $id - Идентификатор
//		 * @return bool
//		 */
//		public function allow(int $right, int $id = 0): bool {
//			return Access::allow($right, $this->id, $id);
//		}

	}