<?php

	namespace Base\UI;

	/**
	 * Секции
	 */
	class Section {
		private array $contents = [];

		/**
		 * Добавляет контент в секцию
		 * @param string ...$contents - Контент
		 * @return void
		 */
		public function push(string ...$contents): void {
			foreach ($contents as $content) $this->contents[] = $content;
		}

		/**
		 * Выводит содержимое секции
		 * @return void
		 */
		public function browse(): void {
			foreach ($this->contents as $content) echo $content;
		}

	}