<?php

	declare(strict_types=1);

	namespace Base;

	/**
	 * Базовый класс работы с правами пользователя
	 */
	class Access {
		use Singleton;

		const PERMISSION_UNDEFINED		= 'undefined';
		const PERMISSION_YES			= 'yes';
		const PERMISSION_NO				= 'no';

		public static int | null $userId = null;
		public static int | null $userGroup = null;

		private static array $superUsers = [];

		private static array $groupsRights = [];
		private static array $usersRights = [];
		private static array $accesses = [];

		/**
		 * Устанавливает данные пользователя
		 * @param int|null $userId - Идентификатор пользователя
		 * @param int|null $userGroupID - Идентификатор группы
		 * @return void
		 */
		public function setUserData(?int $userId, ?int $userGroupID): void {
			self::$userId = $userId;
			self::$userGroup = $userGroupID;
		}

		/**
		 * Регистрирует суперпользователей
		 * @param array $users - Перечень идентификаторов суперпользователей
		 * @return void
		 */
		public function regSuperUsers(array $users): void {
			self::$superUsers = $users;
		}

		/**
		 * Добавляет коллекцию
		 * @param int $id - Идентификатор коллекции
		 * @param string $name - Имя
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function addCollection(int $id, string $name, string $title = ''): void {
			self::$accesses[$id] = ['name' => $name, 'title' => $title, 'rights' => []];
		}

		/**
		 * Добавляет право в коллекцию
		 * @param int $collection - Идентификатор коллекции
		 * @param int $id - Идентификатор права
		 * @param string $name - Название
		 * @param $title - Заголовок
		 * @return void
		 */
		public function addRight(int $collection, int $id, string $name, $title = ''): void {
			self::$accesses[$collection]['rights'][] = ['id' => $id, 'name' => $name, 'title' => $title];
		}

//		public static function GetRights(): array {
//			return self::$accesses;
//		}

		/**
		 * Устанавливает права групп
		 * @param array $rights - Права
		 * @return void
		 */
		public function setGroupsRights(array $rights): void {
			self::$groupsRights = $rights;
		}

		/**
		 * Устанавливает права пользователей
		 * @param array $rights - Права
		 * @return void
		 */
		public function setUsersRights(array $rights): void {
			self::$usersRights = $rights;
		}

//		public static function Allows(array $rights, int $collection, int $instance): bool {
//			if (!isset(self::$userId) || !isset(self::$userGroup)) return false;
//			if (in_array(self::$userId, self::$superUsers)) return true;
//			foreach ($rights as $right) if (self::Allow($right, $collection, $instance)) return true;
//			return false;
//		}

		/**
		 * Проверка права
		 * @param int $right - Право
		 * @param int $collection - Коллекция
		 * @param int $instance - Экземпляр
		 * @return bool
		 */
		public function allow(int $right, int $collection, int $instance = 0): bool {
			if (!isset(self::$userId) || !isset(self::$userGroup)) return false;
			if (in_array(self::$userId, self::$superUsers)) return true;
			switch (self::allowUser($right, self::$userId, $collection, $instance)) {
				case self::PERMISSION_YES: return true;
				case self::PERMISSION_NO: return false;
			}
			if (self::allowGroup($right, self::$userGroup, $collection, $instance) == self::PERMISSION_YES) return true;
			return false;
		}

		/**
		 * Проверка права по группе
		 * @param int $right - Право
		 * @param int $group - Группа
		 * @param int $collection - Коллекция
		 * @param int $instance - Экземпляр
		 * @return string
		 */
		private function allowGroup(int $right, int $group, int $collection, int $instance): string {
			if ($instance && isset(self::$groupsRights[$group][$collection][$instance][$right])) return self::$groupsRights[$group][$collection][$instance][$right];
			if (!isset(self::$groupsRights[$group][$collection][0][$right])) return self::PERMISSION_UNDEFINED;
			return self::$groupsRights[$group][$collection][0][$right];
		}

		/**
		 * Проверка права по пользователю
		 * @param int $right - Право
		 * @param int $user	- Пользователь
		 * @param int $collection - Коллекция
		 * @param int $instance - Экземпляр
		 * @return string
		 */
		private function allowUser(int $right, int $user, int $collection, int $instance): string {
			if ($instance && isset(self::$usersRights[$user][$collection][$instance][$right])) return self::$usersRights[$user][$collection][$instance][$right];
			if (!isset(self::$usersRights[$user][$collection][0][$right])) return self::PERMISSION_UNDEFINED;
			return self::$usersRights[$user][$collection][0][$right];
		}

	}