<?php

	namespace Base;

	trait Instance {
		private static ?self $instance = null;

		public static function instance(): ?self { return self::$instance; }
		public static function init(mixed ...$params): void { if (!self::$instance) self::$instance = new self(...$params); }
	}