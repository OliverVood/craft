<?php

	namespace Base;

	use base\data\set\Input;

	abstract class Route {
		private static ?string $entity = 'main';
		private static ?string $action = 'index';

		private static Input $input;

		private static array $stack = [];

		public static function prepare($url): void {
			$parts = explode('/', $url);

			if (isset($parts[0]) && ($parts[0] != '')) self::$entity = $parts[0];
			if (isset($parts[1]) && ($parts[1] != '')) self::$action = $parts[1];
		}

		public static function set(string $customer, string $performer = ''): void {
			self::$stack[$customer][] = $performer ?: $customer;
		}

		public static function run(): void {
			self::$input = new Input();

			$any_any = '*::*';
			$ins_any = self::$entity . '::*';
			$ins_ins = self::$entity . '::' . self::$action;

			foreach (self::$stack as $customer => $performers) {
				foreach ($performers as $performer) {
					[$controller, $method] = explode('::', $performer);
					if ($customer == $any_any || $customer == $ins_any || $customer == $ins_ins) Controller::run($controller, $method, self::$input);
				}
			}
		}

	}