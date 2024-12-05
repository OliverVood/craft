<?php

	namespace Base\Editor\Skins\Browse;

	use Base\Editor\Skins\Skin;
	use DateTime;
	use Exception;

	/**
	 * Скин для вывода даты/времени
	 */
	class Date extends Skin {
		protected string $format;

		public function __construct(string $name, string $title = '', $format = 'd.m.Y H:i:s') {
			parent::__construct('date', $name, $title);

			$this->format = $format;
		}

		/**
		 * Форматирует и возвращает дату/время
		 * @param string $value - Дата/время
		 * @return string
		 */
		public function format(string $value): string {
			try {
				$date = date_format(new DateTime($value), $this->format);
			} catch (Exception) {
				$date = '';
			}

			return $date;
		}

	}