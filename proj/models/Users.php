<?php

	declare(strict_types=1);

	namespace Proj\Models;

	use Base\DB\DB;
	use Base\Model;

	/**
	 * Модель пользователей
	 */
	class Users extends Model {
		const TABLE_USERS = 'users';
		const TABLE_ACCESS_GROUPS = 'access_groups';
		const TABLE_ACCESS_USERS = 'access_users';

		private DB $db;
		private static bool $auth = false;

		private static int | null $id = null;
		private static int | null $group = null;
		private static string | null $alias = null;

		public function __construct() {
			parent::__construct();

			$this->db = app()->db('craft');

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

			$response = $this->db
				->select()
				->table(self::TABLE_USERS)
				->fields('id', 'gid', 'login', 'password')
				->where('login', $login)
				->where('password', $password)
				->query();

			$data = $response->get();

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

			self::$id = (int)$data['id'];
			self::$group = (int)$data['gid'];
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
			session()->set(self::$auth, 'ADMIN', 'USER', 'AUTH');

			session()->set(self::$id, 'ADMIN', 'USER', 'ID');
			session()->set(self::$group, 'ADMIN', 'USER', 'GROUP');
			session()->set(self::$alias, 'ADMIN', 'USER', 'ALIAS');
		}

		/**
		 * Обновляет данные пользователя собрав их из сессии
		 * @return void
		 */
		private function updateDataFromSession(): void {
			if (session()->get('ADMIN', 'USER') !== null) {
				self::$auth = session()->get('ADMIN', 'USER', 'AUTH') ?? false;

				self::$id = session()->get('ADMIN', 'USER', 'ID') ?? null;
				self::$group = session()->get('ADMIN', 'USER', 'GROUP') ?? null;
				self::$alias = session()->get('ADMIN', 'USER', 'ALIAS') ?? null;
			}
		}

		/**
		 * Обновляет права пользователя
		 * @return void
		 */
		private function updateAccess(): void {
			access()->setUserData(self::$id, self::$group);

			$response = $this->db
				->select()
				->table(self::TABLE_ACCESS_GROUPS)
				->fields('*')
				->query();

			$groupsRights = [];
			foreach ($response->each() as $row) {
				$groupsRights[$row['parent']][$row['feature']][$row['instance']][$row['right']] = $row['permission'];
			}
			access()->setGroupsRights($groupsRights);

			$response = $this->db
				->select()
				->table(self::TABLE_ACCESS_USERS)
				->fields('*')
				->query();
			$usersRights = [];
			foreach ($response->each() as $row) {
				$usersRights[$row['parent']][$row['feature']][$row['instance']][$row['right']] = $row['permission'];
			}
			access()->setUsersRights($usersRights);
		}

		/**
		 * Возвращает идентификатора пользователя
		 * @return int|null
		 */
		public function getId(): ?int {
			return self::$id ?? null;
		}

		/**
		 * Возвращает псевдоним пользователя
		 * @return string
		 */
		public function getAlias(): string {
			return self::$alias ?? '';
		}

	}