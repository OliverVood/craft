<?php

	namespace Base;

	use base\data\set\Input;
	use Base\Data\Set\Old;
	use Exception;

	/**
	 * Маршрутизатор
	 */
	abstract class Route {
		const SOURCE_CONTROLLERS = 1;
		const SOURCE_EDITORS = 2;

		private static ?string $entity = 'main';
		private static ?string $action = 'index';

		private static Input $input;

		private static array $stack = [];

		/**
		 * Подготавливает маршрутизатор
		 * @param $url - URL
		 * @return void
		 *
		 */
		public static function prepare($url): void {
			$parts = explode('/', $url);

			if (isset($parts[0]) && ($parts[0] != '')) self::$entity = $parts[0];
			if (isset($parts[1]) && ($parts[1] != '')) self::$action = $parts[1];
		}

		public static function set(string $customer, string $performer, int $source = self::SOURCE_CONTROLLERS): void {
			self::$stack[] = ['customer' => $customer, 'performer' => $performer, 'source' => $source];
		}

		/**
		 * Выполняет маршрутизацию
		 * @return void
		 * @throws Exception
		 */
		public static function run(): void {
			self::$input = new Input();

			$any_any = '*::*';
			$ins_any = self::$entity . '::*';
			$ins_ins = self::$entity . '::' . self::$action;

			$i = 0;
			while ($i < count(self::$stack)) {
				$customer = self::$stack[$i]['customer'];
				$performer = self::$stack[$i]['performer'];
				$source = self::$stack[$i]['source'];

				$parts = explode('::', $performer);
				$controller = $parts[0];
				$method = $parts[1] ?? '';

				if ($customer == $any_any || $customer == $ins_any || $customer == $ins_ins) Controller::run($source, $controller, $method, self::$input);

				$i++;
			}
		}

		/**
		 * Возвращает данные от предыдущего запроса
		 * @param string|null $key - Ключ
		 * @return Old
		 */
		public static function getOld(?string $key = null): Old {
			return self::$input->old($key);
		}

	}