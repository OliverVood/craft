<?php

	namespace Base\Template;

	trait Buffer {

		public static function start(): void {
			ob_start();
		}

		public static function read(): string {
			$val = ob_get_contents();
			ob_end_clean();

			return $val !== false ? $val : '';
		}

	}