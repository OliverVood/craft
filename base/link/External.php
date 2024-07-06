<?php

	namespace Base\Link;

	/**
	 * Работа с внутренними ссылками
	 */
	class External {
		protected string $address;
		protected string $click;

		public function __construct(string $address = '', string $click = '') {
			$this->address 	= $address;
			$this->click 	= $click;
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