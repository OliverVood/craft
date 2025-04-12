<?php

	declare(strict_types=1);

	namespace Proj\Structures\Craft;

	use Base\Access;
	use Base\DB\Table;

	/**
	 * Структура таблиц клиентов и пользователей
	 */
	class Users {
		private Table $table_clients;
		private Table $table_groups;
		private Table $table_users;
		private Table $table_access_groups;
		private Table $table_access_users;

		public function __construct() {
			$structure = db('craft')->structure();

			$this->table_clients = $structure->table('clients', __('Клиенты'));
			$this->table_clients->id('id', __('Идентификатор'));
			$this->table_clients->timestamp('datecr', false, __('Дата создания'));
			$this->table_clients->timestamp('datemd', true, __('Дата изменения'));
			$this->table_clients->string('hash', 64, __('Хэш'));

			$this->table_groups = $structure->table('groups', __('Группы'));
			$this->table_groups->id('id', __('Идентификатор'));
			$this->table_groups->uint8('state', __('Состояние'));
			$this->table_groups->timestamp('datecr', false, __('Дата создания'));
			$this->table_groups->timestamp('datemd', true, __('Дата изменения'));
			$this->table_groups->string('name', 50, __('Наименование'));

			$this->table_users = $structure->table('users', __('Пользователи'));
			$this->table_users->id('id', __('Идентификатор'));
			$this->table_users->uint8('state', __('Состояние'));
			$this->table_users->timestamp('datecr', false, __('Дата создания'));
			$this->table_users->timestamp('datemd', true, __('Дата изменения'));
			$this->table_users->uint32('gid', __('ID Группы'));
			$this->table_users->string('login', 50, __('Логин'));
			$this->table_users->string('password', 32, __('Пароль'));
			$this->table_users->string('first_name', 50, __('Имя'));
			$this->table_users->string('last_name', 50, __('Фамилия'));
			$this->table_users->string('father_name', 50, __('Отчество'));
			$this->table_users->addForeign('foreign', ['gid'],'groups', ['id']);

			$this->table_access_groups = $structure->table('access_groups', __('Безопасность групп'));
			$this->table_access_groups->uint32('parent', __('ID группы'));
			$this->table_access_groups->uint16('feature', __('Признак'));
			$this->table_access_groups->uint32('instance', __('Экземпляр '));
			$this->table_access_groups->uint16('right', __('Право'));
			$this->table_access_groups->enum('permission', [Access::PERMISSION_UNDEFINED, Access::PERMISSION_YES, Access::PERMISSION_NO], __('Разрешение'));

			$this->table_access_users = $structure->table('access_users', __('Безопасность пользователей'));
			$this->table_access_users->uint32('parent', __('ID пользователя'));
			$this->table_access_users->uint16('feature', __('Признак'));
			$this->table_access_users->uint32('instance', __('Элемент'));
			$this->table_access_users->uint16('right', __('Право'));
			$this->table_access_users->enum('permission', [Access::PERMISSION_UNDEFINED, Access::PERMISSION_YES, Access::PERMISSION_NO], __('Разрешение'));
		}

	}

	new Users();