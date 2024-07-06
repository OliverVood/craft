<?php

	namespace proj\models;

	use Base\Model;

	/**
	 * Модель пользователей
	 */
	class User extends Model {
		private static bool $auth = false;

		private static string | null $id = null;
		private static string | null $group = null;
		private static string | null $alias = null;

		public function __construct() {
			$this->updateDataFromSession();
//			if ($this->isAuth()) $this->UpdateAccess();
		}

		/**
		 * Аутентифицирует пользователя
		 * @param string $login - Логин
		 * @param string $password - Пароль
		 * @return bool
		 */
		public function auth(string $login, string $password): bool {//TODO db_instance
//			$login = $this->db->Escaping($login);
//			$hash = $this->PasswordHash($password);
//
//			$data = $this->db->SelectOne(Consts\Users::TABLES['users'], ['id', 'gid', 'login', 'password'], "`login` = '{$login}' AND `password` = '{$hash}'");
//
//			if (!$data) return false;
//
//			$this->Login($data);
//
			return true;
		}

		/**
		 * Проверяет аутентифицирован ли пользователь
		 * @return bool
		 */
		public function isAuth(): bool {
			return self::$auth;
		}

		/**
		 * Обновляет данные пользователя собрав их из сессии
		 * @return void
		 */
		private function updateDataFromSession(): void {
			if (isset($_SESSION['ADMIN']['USER'])) {
				self::$auth = $_SESSION['ADMIN']['USER']['AUTH'] ?? false;

				self::$id = $_SESSION['ADMIN']['USER']['ID'] ?? false;
				self::$group = $_SESSION['ADMIN']['USER']['GROUP'] ?? false;
				self::$alias = $_SESSION['ADMIN']['USER']['ALIAS'] ?? false;
			}
		}

	}