<?php

	declare(strict_types=1);

	namespace Base\Link;

	use Base\Access;

	/**
	 * Класс ссылок, работающих через права пользователя
	 */
	class Right extends Internal {
		private int $collection;
		private int $right;

		/**
		 * @param int $collection - Идентификатор коллекции
		 * @param int $right - Идентификатор права
		 * @param string $path - Путь
		 * @param string $click - Обработчик события
		 */
		public function __construct(int $collection, int $right, string $path = '', string $click = '') {
			parent::__construct($path, $click);

			$this->collection = $collection;
			$this->right = $right;
		}

		/**
		 * Проверка прав
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		public function allow(int $id = 0): bool {
			return Access::allow($this->collection, $this->right, $id);
		}

		/**
		 * Возвращает ссылку anchor
		 * @param string $content - Контент
		 * @param array $data - Данные для замены
		 * @param array $params - Параметры
		 * @return string
		 */
		public function linkHref(string $content, array $data = [], array $params = []): string {
			return $this->allow() ? parent::linkHref($content, $data, $params) : '';
		}

		/**
		 * Возвращает ссылку anchor
		 * @param int $id - Идентификатор
		 * @param string $content - Контент
		 * @param array $data - Данные для замены
		 * @param array $params - Параметры
		 * @return string
		 */
		public function linkHrefID(int $id, string $content, array $data = [], array $params = []): string {
			return $this->allow($id) ? parent::linkHref($content, $data, $params) : '';
		}

	}