<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Для создания единственного экземпляра класса (синглтон)
	 */
	trait Instance {
		private static ?self $instance = null;

		/**
		 * Возвращает экземпляр класса
		 * @param mixed ...$params - Параметры инициализации
		 */
		public static function instance(mixed ...$params): self {
			if (!self::$instance) self::$instance = new self(...$params);

			return self::$instance;
		}

	}