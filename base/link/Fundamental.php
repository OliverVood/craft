<?php

	declare(strict_types=1);

	namespace Base\Link;

	/**
	 * Фундаментальный класс ссылок
	 */
	abstract class Fundamental {
		protected string $address;
		protected string $click;

		/**
		 * @param string $address - Адрес ссылки
		 * @param string $click - Обработчик события
		 */
		protected function __construct(string $address, string $click) {
			$this->address = $address;
			$this->click = $click;
		}

		/**
		 * Возвращает адрес ссылки
		 * @param array $data - Данные для замены
		 * @return string
		 */
		public function address(array $data = []): string {
			return $this->prepare($this->address, $data);
		}

		/**
		 * Возвращает обработчик события
		 * @param array $data - Данные для замены
		 * @return string
		 */
		public function click(array $data = []): string {
			return $this->prepare($this->click, $data);
		}

		/**
		 * Возвращает гиперссылку
		 * @param string $content - Содержимое
		 * @param array $data - Данные для замены
		 * @param array $params - Парамеры ссылки
		 * @return string
		 */
		public function hyperlink(string $content, array $data = [], array $params = []): string {
			$params['href'] = $params['href'] ?? $this->address($data);
			$params['onclick'] = $this->click($data);

			$attrs = [];
			foreach ($params as $key => $value) $attrs[] = is_int($key) ? $value : "{$key} = \"{$value}\"";
			$attrs = implode(' ', $attrs);

			return "<a {$attrs}>{$content}</a>";
		}

		/**
		 * Подготавливает текст делая подстановку данных
		 * @param string $text - Текст
		 * @param array $data - Данные для замены
		 * @return string
		 */
		protected function prepare(string $text, array $data): string {
			if ($text === '' && !$data) return $text;

			foreach ($data as $key => $value) $text = str_replace(":[{$key}]", (string)$value, $text);

			return $text;
		}

	}