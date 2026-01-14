<?php

	namespace Base\Helper;

	/**
	 * Перевод
	 */
	abstract class Translation {
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
			'' => '',
			'' => '',
			'' => '',
			'' => '',
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