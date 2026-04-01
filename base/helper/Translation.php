<?php

	namespace Base\Helper;

	/**
	 * Перевод
	 */
	abstract class Translation {//todo
		private static array $translations = [
			'Выход' => 'log out',
			'Зарегистрирован' => 'Registered',
			'ID' => 'ID',
			'GID' => 'GID',
			'Открыть сайт' => 'Open Website',
			'Главная' => 'Home',
			'Разработка' => 'Development',
			'Ремесло' => 'Craft',
			'Создать' => 'Create',
			'База данных' => 'Database',
			'Статистика' => 'Statistic',
			'Документация' => 'Documentation',
			'Помощь' => 'Help',
			'Признак' => 'Feature',
			'Контроллер' => 'Controller',
			'Модель' => 'Model',
			'Редактор' => 'Editor',
			'Отображение' => 'View',
			'Компонент' => 'Component',
			'Структуру' => 'Structure',
			'Проверить' => 'Check',
			'Структура' => 'Structure',
			'Запросы к серверу' => 'Server',
			'Действия клиента' => 'Actions',
			'Группы' => 'Groups',
			'Список' => 'List',
			'Добавить' => 'Add',
			'Пользователи' => 'Users',
			'Безопасность' => 'Access',
			'Новости' => 'News',
			'Изменения' => 'Changes',
			'Обратная связь' => 'Feedback',
			'Сайт' => 'Website',
			'База данных исправна.' => 'The database is ok.',
			'Структура базы данных' => 'Database structure',
			'Дата' => 'Date',
			'ID Клиента' => 'Client ID',
			'Объект' => 'Object',
			'Действие' => 'Action',
			'Параметры' => 'Options',
			'Статистика запросов к серверу' => 'Server request statistics',
			'Статистика действий клиентов' => 'Customer activity statistics',
			'Проверка базы данных' => 'Database check',
			'IP адрес' => 'IP address',
			'Метод' => 'Method',
			'Виртуальный метод' => 'Virtual method',
			'Создание признака' => 'Creating a feature',
			'Назначение прав' => 'Assigning Permissions',
			'Выборка' => 'Selection',
			'Вывод' => 'Output',
			'Создание' => 'Create',
			'Изменение' => 'Modify',
			'Удаление' => 'Delete',
			'Изменение состояния' => 'Change State',
			'Псевдоним признака' => 'Feature alias',
			'Ошибка валидации данных' => 'Data validation error',
			'Псевдоним признака не указан' => 'The feature alias is not specified',
			'Создание контроллера' => 'Create a Controller',
			'Псевдоним контроллера' => 'Controller Alias',
			'Создать модель' => 'Create a Model',
			'Псевдоним контроллера не указан' => 'The controller alias is not specified.',
			'Создание модели' => 'Create a model',
			'Псевдоним модели' => 'Model alias',
			'Использовать базу данных' => 'Use a database',
			'Псевдоним модели не указан' => 'The Model alias is not specified',
			'Создание редактора' => 'Creating an editor',
			'Псевдоним редактора' => 'Editor alias',
			'Псевдоним базы данных' => 'Database alias',
			'Название таблицы' => 'Table name',
			'Псевдоним редактора не указан' => 'The editor alias is not specified',
			'База данных не указана' => 'Database not specified',
			'Таблица не указана' => 'Table not specified',
			'Редактор \':[name]\' создан' => 'The \':[name]\' editor has been created',
			'Контроллер редактора \':[name]\' уже существует' => 'Editor controller \':[name]\' already exists',
			'Модель редактора \':[name]\' уже существует' => 'Editor model \':[name]\' already exists',
			'Создание отображения' => 'Creating a Display',
			'Псевдоним отображения' => 'Display Alias',
			'Псевдоним отображения не указан' => 'Display alias not specified',
			'Отображение \':[file]\' уже существует' => 'Display \':[file]\' already exists',
			'Отображение \':[file]\' создано' => 'Display \':[file]\' created',
			'Создание компонента' => 'Creating a component',
			'Псевдоним компонента' => 'Component alias',
			'Псевдоним компонента не указан' => 'Component alias not specified',
			'Компонент \':[file]\' уже существует' => 'Component \':[file]\' already exists',
			'"Компонент \':[file]\' создан' => '"Component \':[file]\' created',
			'Создание структуры' => 'Create a structure',
			'Псевдоним структуры' => 'Structure alias',
			'Добавить таблицу' => 'Add a table',
			'Псевдоним структуры не указан' => 'Structure alias not specified',
			'Псевдоним базы данных не указан' => 'Database alias not specified',
			'Структура \':[name]\' уже существует' => 'Structure \':[name]\' already exists',
			'Структура \':[name]\' создана' => 'Structure \':[name]\' created',
			'Поле «:[name]» обязательно для заполнения' => 'The field ":[name]" is required',
			'Список групп' => 'List of groups',
			'Управление' => 'Management',
			'Наименование' => 'Name',
			'Состояние' => 'Status',
			'Ошибка' => 'Error',
			'Активная' => 'Active',
			'Не активная' => 'Inactive',
			'Удалена' => 'Removed',
			'Изменить' => 'Edit',
			'Установить права доступа' => 'Set access rights',
			'Удалить' => 'Delete',
			'Права группы' => 'Group rights',
			'Проверить БД' => 'Check the database',
			'Исправить БД' => 'Fix the database',
			'Структура БД' => 'Database structure',
			'Права группы установлены' => 'Group rights have been set',
			'Группа удалена' => 'The group has been deleted',
			'Группа добавлена' => 'The group has been added',
			'Добавление группы' => 'Adding a group',
			'Список пользователей' => 'List of users',
			'Логин' => 'Login',
			'Имя' => 'First Name',
			'Фамилия' => 'Last Name',
			'Отчество' => 'Patronym',
			'Группа' => 'Group',
			'Права пользователя' => 'User rights',
			'Добавление пользователя' => 'Adding a user',
			'Пароль' => 'Password',
			'Повторение пароля' => 'Repeat password',
			'Длина поля «:[name]» не может быть меньше :[min]' => 'The length of the field ":[name]" cannot be less than :[min]',
			'Поле «:[name]» должно содержать цифры' => 'The ":[name]" field must contain numbers',
			'Поле «:[name]» должно содержать буквы' => 'The ":[name]" field must contain letters',
			'Поле «:[name]» должно содержать строчные буквы' => 'The ":[name]" field must contain lowercase letters',
			'Поле «:[name]» должно содержать прописные буквы' => 'The ":[name]" field must contain uppercase letters',
			'Поле «:[name]» должно содержать специальные символы' => 'The ":[name]" field must contain special characters',
			'Значение поля «:[name]» не совпадает cо значением поля «:[name_original]»' => 'The value of the field ":[name]" does not match the value of the field ":[name_original]"',
			'Пользователь добавлен' => 'User added',
			'Значение поля «:[name]» уже существует в таблице «:[table]»' => 'The value of field ":[name]" already exists in table ":[table]"',
			'Просмотр пользователя' => 'View user',
			'Изменение пользователя' => 'Changing user',
			'Пользователь изменён' => 'User has been changed',
			'Пользователь удалён' => 'The user has been deleted',
		];

		/**
		 * Возвращает перевод
		 * @param string $alias - Псевдоним
		 * @param array $params - Параметры
		 * @return string
		 */
		public static function get(string $alias, array $params = []): string {
			$translate = self::$translations[$alias] ?? $alias;
			return $params ? self::prepare($translate, $params) : $translate;
		}

		/**
		 * Подготавливает текст делая постановки
		 * @param string $text - Текст
		 * @param array $params - Параметры замены
		 * @return string
		 */
		public static function prepare(string $text, array $params = []): string {
			foreach ($params as $key => $value) $text = str_replace(":[$key]", $value, $text);
			return $text;
		}

	}