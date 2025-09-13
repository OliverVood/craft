<?php

	namespace Base\Helper;

	use Exception;
	use stdClass;

	/**
	 * Отметки времени
	 */
	abstract class Timestamp {
		private static array $timestamps = [];

		/**
		 * Задаёт начало отметки
		 * @param string $name - Название
		 * @return string
		 */
		public static function start(string $name = ''): string {
			if (!$name) $name = uniqid('default_');

			if (isset(self::$timestamps[$name])) app()->error(new Exception(__("Timestamp '{$name}' already exists")));

			self::$timestamps[$name] = new stdClass();

			self::$timestamps[$name]->name = $name;
			self::$timestamps[$name]->start = microtime(true);
			self::$timestamps[$name]->stop = null;
			self::$timestamps[$name]->duration = null;
			self::$timestamps[$name]->stamps = [];

			return $name;
		}

		/**
		 * Ставит отметку времени
		 * @param string $name - Название
		 * @param string $mark - Название промежуточной отметки
		 * @return void
		 */
		public static function stamp(string $name, string $mark = ''): void {
			if (!isset(self::$timestamps[$name])) app()->error(new Exception(__("Timestamp '{$name}' not found")));
			if (self::$timestamps[$name]->stop) app()->error(new Exception(__("Timestamp '{$name}' already finished")));

			$time = microtime(true);

			$stamp = new stdClass();

			$stamp->name = $mark;
			$stamp->time = $time;
			$stamp->duration = self::duration(self::$timestamps[$name]->start, $time);

			self::$timestamps[$name]->stamps[] = $stamp;
		}

		/**
		 * Задаёт конец отметки
		 * @param string $name - Название
		 * @return void
		 */
		public static function stop(string $name): void {
			if (!isset(self::$timestamps[$name])) app()->error(new Exception(__("Timestamp '{$name}' not found")));
			if (self::$timestamps[$name]->stop) app()->error(new Exception(__("Timestamp '{$name}' already finished")));

			self::$timestamps[$name]->stop = microtime(true);
			self::$timestamps[$name]->duration = self::duration(self::$timestamps[$name]->start, self::$timestamps[$name]->stop);
		}

		/**
		 * Возвращает список отметок времени
		 * @return array
		 */
		static public function list(): array {
			return self::$timestamps;
		}

		/**
		 * Вычисляет длительность
		 * @param $start - Начало
		 * @param $stop - Конец
		 * @return int
		 */
		private static function duration($start, $stop): int {
			return (int)(round($stop - $start, 6)  * 1000000);
		}

	}