<?php

	declare(strict_types=1);

	namespace Base;

	use Base\Link\Fundamental;

	/**
	 * Для работы со ссылками
	 * @property Fundamental[] $links
	 */
	class Links {
		use Singleton;

		private array $links = [];

		/**
		 * Регистрирует ссылку
		 * @param string $alias - Псевдоним
		 * @param Fundamental $link - Ссылка
		 * @return void
		 */
		public function registration(string $alias, Fundamental $link): void {
			$this->links[$alias] = $link;
		}

		/**
		 * Проверяет наличие ссылки
		 * @param string $alias - Псевдоним ссылки
		 * @return bool
		 */
		public function check(string $alias): bool {
			return isset($this->links[$alias]);
		}

		/**
		 * Возвращает ссылку по псевдониму
		 * @param string $alias - Псевдоним ссылки
		 * @return Fundamental
		 */
		public function get(string $alias): Fundamental {
			return $this->links[$alias];
		}

	}