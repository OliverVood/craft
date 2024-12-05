<?php

	namespace Base\Helper;

	use Generator;

	/**
	 * Для аккумулирования данных
	 */
	class Accumulator {
		private array $list = [];

		/**
		 * Добавляет элемент
		 * @param mixed $element - Элемент
		 * @return void
		 */
		public function push(mixed $element): void {
			$this->list[] = $element;
		}

		/**
		 * Проверяет на пустоту
		 * @return bool
		 */
		public function isEmpty(): bool {
			return empty($this->list);
		}

		/**
		 * Возвращает количество элементов
		 * @return int
		 */
		public function count(): int {
			return count($this->list);
		}

		/**
		 * Возвращает первый элемент
		 * @return mixed
		 */
		public function first(): mixed {
			return $this->list[0];
		}

		/**
		 * Проход по всем элементам
		 * @return Generator
		 */
		public function each(): Generator {
			foreach ($this->list as $element) yield $element;

			return null;
		}

	}