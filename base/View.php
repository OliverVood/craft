<?php

	namespace Base;

	use Base\Template\Buffer;

	abstract class View {
		use Buffer;

		public static function get(string $view, array $data = []): string {
			$options = [
				'view' => str_replace('.', '/', $view)
			];

			self::start();

			$scop = function(array $options, array $data) {
				extract($data);
				require DIR_PROJ_VIEWS . $options['view'] . '.tpl';
			};

			$scop($options, $data);

			return self::read();
		}

	}