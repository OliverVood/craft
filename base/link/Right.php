<?php

	declare(strict_types=1);

	namespace Base\Link;

	/**
	 * Класс ссылок, работающих через права пользователя
	 */
	class Right extends Internal {
		private int $feature;
		private int $right;

		/**
		 * @param int $features - Идентификатор признака
		 * @param int $right - Идентификатор права
		 * @param string $path - Путь
		 * @param string $click - Обработчик события
		 */
		public function __construct(int $features, int $right, string $path = '', string $click = '') {
			parent::__construct($path, $click);

			$this->feature = $features;
			$this->right = $right;
		}

		/**
		 * Проверка прав
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		public function allow(int $id = 0): bool {
			return access()->allow($this->feature, $this->right, $id);
		}

		/**
		 * Возвращает ссылку
		 * @param string $content - Контент
		 * @param array $data - Данные для замены
		 * @param array $params - Параметры
		 * @return string
		 */
		public function hyperlink(string $content, array $data = [], array $params = []): string {
			return $this->allow() ? parent::hyperlink($content, $data, $params) : '';
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
			return $this->allow($id) ? parent::hyperlink($content, $data, $params) : '';
		}

	}