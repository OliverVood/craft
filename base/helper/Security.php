<?php

	namespace Base\Helper;

	use Exception;

	/**
	 * Криптография
	 */
	abstract class Security {
		/**
		 * Возвращает или генерирует CSRF
		 * @return string
		 */
		public static function csrf(): string {
			$csrfValueOld = session()->get('SECURITY', 'CSRF', 'VALUE') ?? '';
			$csrfValueTime = session()->get('SECURITY', 'CSRF', 'TIME') ?? 0;

			$csrfTime = env('APP_CSRF_TIME', 0);

			$csrf = $csrfValueOld;

			if (!$csrfValueOld || ($csrfTime && time() > $csrfValueTime + $csrfTime)) {
				try {
					$csrf = bin2hex(random_bytes(24));
					$time = time();

					session()->set($csrf, 'SECURITY', 'CSRF', 'VALUE');
					session()->set($time, 'SECURITY', 'CSRF', 'TIME');

				} catch (Exception $e) {
					app()->error($e);
				}
			}

			return $csrf;
		}

	}