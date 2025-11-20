<?php

	declare(strict_types=1);

	namespace Base\Access;

	use Base\Link\External;
	use Base\Link\Fundamental;
	use Base\Link\Right;
	use Base\Singleton;

	/**
	 * Для работы со ссылками
	 * @property External[] $links
	 */
	class Links {
		use Singleton;

		private array $links = [];

		/**
		 * Регистрирует внутреннюю ссылку
		 * @param string $alias - Псевдоним ссылки
		 * @param string $feature - Наименование признака
		 * @param string $right - Наименование права
		 * @param string $address - Адрес
		 * @param string $click - Обработчик
		 * @return void
		 */
		public function right(string $alias, string $feature, string $right, string $address = '', string $click = ''): void {
			$this->registration($alias, new Right(feature($feature)->id(), feature($feature)->rights($right)->id(), $address, $click));
		}

		/**
		 * Регистрирует ссылку
		 * @param string $alias - Псевдоним
		 * @param External $link - Ссылка
		 * @return void
		 */
		private function registration(string $alias, Fundamental $link): void {
			$this->links[$alias] = $link;
		}

	}