<?php

	declare(strict_types=1);

	namespace Base\Access;

	/**
	 * Базовый класс признаков
	 * @property Feature[] $features
	 */
	class Features {
		private array $features = [];

		/**
		 * Регистрирует признак
		 * @param string $class - Класс признака
		 * @param int $id - Идентификатор признака
		 * @param string $name - Наименование признака
		 * @param string $title - Заголовок признака
		 * @return void
		 */
		public function registration(string $class, int $id, string $name, string $title = ''): void {
			/** @var Feature $feature */ $feature = new $class($id, $name, $title);
			$this->features[$feature->name()] = $feature;
		}

		/**
		 * Возвращает признак
		 * @param string $name - Наименование признака
		 * @return Feature
		 */
		public function get(string $name): Feature {
			return $this->features[$name];
		}

	}