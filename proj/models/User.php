<?php

	namespace proj\models;

	use Base\Model;

	class User extends Model {
		private static bool $auth = false;

		private static string | null $id = null;
		private static string | null $group = null;
		private static string | null $alias = null;

		public function __construct() {
			$this->updateDataFromSession();
//			if ($this->isAuth()) $this->UpdateAccess();
		}

		public function isAuth(): bool {
			return self::$auth;
		}

		private function updateDataFromSession(): void {
			if (isset($_SESSION['ADMIN']['USER'])) {
				self::$auth = $_SESSION['ADMIN']['USER']['AUTH'] ?? false;

				self::$id = $_SESSION['ADMIN']['USER']['ID'] ?? false;
				self::$group = $_SESSION['ADMIN']['USER']['GROUP'] ?? false;
				self::$alias = $_SESSION['ADMIN']['USER']['ALIAS'] ?? false;
			}
		}

	}