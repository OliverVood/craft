<?php

	declare(strict_types=1);

	namespace Base\Access;

	use Base\Link\External;
	use Base\Link\Fundamental;
	use Base\Link\Internal;
	use Base\Link\Right;

	/**
	 * Для работы со ссылками
	 * @property External[] $links
	 */
	class Links {
		private array $links = [];

		/**
		 * Регистрирует внешнюю ссылку
		 * @param string $alias - Псевдоним ссылки
		 * @param string $address - Адрес
		 * @param string $click - Обработчик
		 * @return void
		 */
		public function external(string $alias, string $address = '', string $click = ''): void {
			$this->registration($alias, new External($address, $click));
		}

		/**
		 * Регистрирует внутреннюю ссылку
		 * @param string $alias - Псевдоним ссылки
		 * @param string $address - Адрес
		 * @param string $click - Обработчик
		 * @return void
		 */
		public function internal(string $alias, string $address = '', string $click = ''): void {
			$this->registration($alias, new Internal($address, $click));
		}

//		/**
//		 * Регистрирует внутреннюю ссылку
//		 * @param string $alias - Псевдоним ссылки
//		 * @param string $feature - Наименование признака
//		 * @param string $right - Наименование права
//		 * @param string $address - Адрес
//		 * @param string $click - Обработчик
//		 * @return void
//		 */
//		public function right(string $alias, string $feature, string $right, string $address = '', string $click = ''): void {
//			$this->registration($alias, new Right(app()->features($feature)->id(), app()->features($feature)->rights($right)->id(), '*', '*', $address, $click));
//		}

		/**
		 * Регистрирует ссылку
		 * @param string $alias - Псевдоним
		 * @param External $link - Ссылка
		 * @return void
		 */
		private function registration(string $alias, Fundamental $link): void {
			$this->links[$alias] = $link;
		}

		/**
		 * Возвращает внешнюю ссылку по псевдониму
		 * @param string $alias - Псевдоним ссылки
		 * @return External
		 */
		public function getExternal(string $alias): External {
			return $this->links[$alias];
		}

		/**
		 * Возвращает внутреннюю ссылку по псевдониму
		 * @param string $alias - Псевдоним ссылки
		 * @return Internal
		 */
		public function getInternal(string $alias): Internal {
			return $this->links[$alias];
		}

		/**
		 * Возвращает внутреннюю ссылку по псевдониму
		 * @param string $alias - Псевдоним ссылки
		 * @return Right
		 */
		public function getRight(string $alias): Right {
			return $this->links[$alias];
		}

	}