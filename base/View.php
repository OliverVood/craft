<?php

	namespace Base;

	use Base\Template\Buffer;

	/**
	 * Базовый класс для работы с отображениями
	 */
	abstract class View {
		use Buffer;

		/**
		 * Возвращает отображение
		 * @param string $view - Название отображения
		 * @param array $data - Данные
		 * @return string
		 */
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