<?php

	namespace Proj\Models;

	use Base\Access;
	use Base\Model;
	use Proj\DB;

	/**
	 * Модель пользователей
	 */
	class User extends Model {
		const TABLE_USER = 'users';
		const TABLE_ACCESS_GROUPS = 'access_groups';
		const TABLE_ACCESS_USERS = 'access_users';

		private \Base\DB\DB $db;
		private static bool $auth = false;

		private static string | null $id = null;
		private static string | null $group = null;
		private static string | null $alias = null;

		public function __construct() {
			$this->db = DB\Craft::instance();

			$this->updateDataFromSession();
			if ($this->isAuth()) $this->updateAccess();
		}

		/**
		 * Аутентифицирует пользователя
		 * @param string $login - Логин
		 * @param string $password - Пароль
		 * @return bool
		 */
		public function auth(string $login, string $password): bool {
			$login = $this->db->escape($login);
			$hash = $this->getpasswordHash($password);

			$response = $this->db
				->select()
				->table(self::TABLE_USER)
				->fields('id', 'gid', 'login', 'password')
				->where('login', $login)
				->where('password', $hash)
				->query();

			$data = $response->getOne();

			if (!$data) return false;

			$this->login($data);

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
		 * Вход пользователя в систему
		 * @param array $data - Данные для входа
		 * @return void
		 */
		private function login(array $data): void {
			self::$auth = true;

			self::$id = $data['id'];
			self::$group = $data['gid'];
			self::$alias = $data['login'];

			$this->updateSession();
			$this->updateAccess();
		}

		/**
		 * Выход пользователя из системы
		 * @return void
		 */
		public function logout(): void {
			self::$auth = false;

			self::$id = null;
			self::$group = null;
			self::$alias = null;

			$this->updateSession();
			$this->updateAccess();
		}

		/**
		 * Обновляет данные пользователя в сессии
		 * @return void
		 */
		private function updateSession(): void {
			$_SESSION['ADMIN']['USER']['AUTH'] = self::$auth;

			$_SESSION['ADMIN']['USER']['ID'] = self::$id;
			$_SESSION['ADMIN']['USER']['GROUP'] = self::$group;
			$_SESSION['ADMIN']['USER']['ALIAS'] = self::$alias;
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

		/**
		 * Обновляет права пользователя
		 * @return void
		 */
		private function updateAccess(): void {
			Access::setUserData(self::$id, self::$group);

			Access::regSuperUsers(SUPER_USERS);

			$response = $this->db
				->select()
				->table(self::TABLE_ACCESS_GROUPS)
				->fields('*')
				->query();

			$groupsRights = [];
			foreach ($response->each() as $row) {
				$groupsRights[$row['gid']][$row['collection']][$row['instance']][$row['right']] = $row['permission'];
			}
			Access::setGroupsRights($groupsRights);

			$response = $this->db
				->select()
				->table(self::TABLE_ACCESS_USERS)
				->fields('*')
				->query();
			$usersRights = [];
			foreach ($response->each() as $row) {
				$usersRights[$row['uid']][$row['collection']][$row['instance']][$row['right']] = $row['permission'];
			}
			Access::setUsersRights($usersRights);
		}

		/**
		 * Возвращает хеш пароля
		 * @param $pass - Пароль
		 * @return string
		 */
		private function getPasswordHash($pass): string {
			return md5($pass);
		}

		/**
		 * Возвращает псевдоним пользователя
		 * @return string
		 */
		public function getAlias(): string {
			return self::$alias ?? '';
		}

	}