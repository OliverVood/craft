<?php

	namespace Base\Link;

	/**
	 * Работа с внешними ссылками
	 */
	class External {
		protected string $address;
		protected string $click;

		public function __construct(string $address = '', string $click = '') {
			$this->address 	= $address;
			$this->click 	= $click;
		}

		/**
		 * Добавляет внутренний адрес
		 * @return string
		 */
		public function address(): string {
			return $this->address;
		}

		/**
		 * Возвращает ссылку anchor
		 * @param string $href - Адрес
		 * @param string $content - Контент
		 * @param array $data - Данные для замены
		 * @param array $params - Параметры
		 * @return string
		 */
		public function link(string $href, string $content, array $data = [], array $params = []): string {
			$params['href'] = $href;
			$params['onclick'] = $this->click($data);

			$attrsList = [];
			foreach ($params as $name => $value) $attrsList[] = is_int($name) ? $value : "{$name} = \"{$value}\"";
			$attrs = implode(' ', $attrsList);
			return "<a {$attrs}>{$content}</a>";
		}

		/**
		 * Возвращает click
		 * @param array $data - Параметры
		 * @return string
		 */
		public function click(array $data = []): string {
			return $this->ParseTarget($this->click, $data);
		}

		/**
		 * Заменяет параметры в строке
		 * @param string $subject - Строка
		 * @param array  $replace - Массив замен
		 * @return string
		 */
		protected function ParseTarget(string $subject, array $replace): string {
			foreach ($replace as $key => $value) $subject = str_replace("%{$key}%", $value, $subject);

			return  $subject;
		}

	}