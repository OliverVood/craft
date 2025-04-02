<?php

	declare(strict_types=1);

	namespace Base\Access;

	use Exception;
	use Generator;

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
			try {
				if (!isset($this->features[$name])) throw new Exception("Feature '{$name}' not found");
			}
			catch (Exception $e) {
				app()->error($e);
			}
			return $this->features[$name];
		}

		/**
		 * Перебирает признаки
		 * @return Generator
		 */
		public function each(): Generator {
			foreach ($this->features as $feature) yield $feature->name() => $feature;

			return null;
		}

	}