<?php

	namespace Base;

	/**
	 * Для создания единственного экземпляра класса (синглтон)
	 */
	trait Instance {
		private static ?self $instance = null;

		/**
		 * Возвращает синглтон
		 */
		public static function instance(): ?self { return self::$instance; }

		/**
		 * Инициализация синглтона
		 * @param mixed ...$params - Параметры
		 * @return void
		 */
		public static function init(mixed ...$params): void { if (!self::$instance) self::$instance = new self(...$params); }
	}