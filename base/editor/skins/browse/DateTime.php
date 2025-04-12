<?php

	namespace Base\Editor\Skins\Browse;

	use Base\Editor\Skins\Skin;
	use Exception;

	/**
	 * Скин для вывода даты/времени
	 */
	class DateTime extends Skin {
		protected string $format;
		protected bool $client;

		public function __construct(string $name, string $title = '', $format = 'd.m.Y H:i:s', $client = false) {
			parent::__construct('date', $name, $title);

			$this->format = $format;
			$this->client = $client;
		}

		/**
		 * Форматирует и возвращает дату/время
		 * @param string $value - Дата/время
		 * @return string
		 */
		public function format(string $value): string {
			try {
				$datetime = new \DateTime($value, new \DateTimeZone('UTC'));
				$timezone = app()->request()->timezone();
				if ($this->client && $timezone) $datetime->setTimezone(new \DateTimeZone($timezone));
				$datetime = $datetime->format($this->format);
			} catch (Exception) {
				$datetime = '';
			}

			return $datetime;
		}

	}