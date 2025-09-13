<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Помощник
	 */
	class Helper {
		/**
		 * Генерирует путь из строки
		 * @param string $string - Строка
		 * @return string
		 */
		public static function generatePath(string $string): string {
			$parts = explode('.', $string);

			$result = array_map(function ($elem) {
				$parts = explode('_', $elem);
				$parts = array_map(function ($part) { return ucfirst(strtolower($part)); }, $parts);
				return lcfirst(implode('', $parts));
			}, $parts);

			return implode('/', $result) . '/';
		}

		/**
		 * Генерирует имя класса из строки
		 * @param string $string - Строка
		 * @return string
		 */
		public static function generateClassName(string $string): string {
			$parts = explode('_', $string);
			$parts = array_map(function ($part) { return ucfirst(strtolower($part)); }, $parts);
			return implode('', $parts);
		}

		/**
		 * Генерирует пространство имён из строки
		 * @param string $string - Строка
		 * @return string
		 */
		public static function generateNamespace(string $string): string {
			$parts = explode('.', $string);

			$result = array_map(function ($elem) {
				$parts = explode('_', $elem);
				$parts = array_map(function ($part) { return ucfirst(strtolower($part)); }, $parts);
				return implode('', $parts);
			}, $parts);

			return implode('\\', $result);
		}

		/**
		 * Формирует путь и пространство имён из строки
		 * @param string $namespacePrefix - Префикс пространство имён
		 * @param string $pathPrefix - Префикс пути
		 * @param string $name - Строка
		 * @return string[]
		 */
		public static function generateClassInfo(string $namespacePrefix, string $pathPrefix, string $name): array {
			preg_match('/^((.*)\.)?(.+)$/', $name, $matches);

			$class = Helper::generateClassName($matches[3]);

			$path = $pathPrefix;

			$namespace = $namespacePrefix;
			$namespaceSuffix = '';

			/* Формирование вложенного пространства имён и пути */
			if ($matches[2] !== '') {
				$path .= self::generatePath($matches[2]);

				$namespaceSuffix = '\\' . self::generateNamespace($matches[2]);
				$namespace .= $namespaceSuffix;
			}

			return [$path, $namespace, $class, $namespaceSuffix];
		}

		/**
		 * Генерирует содержимое файла и сохраняет его
		 * @param string $sample - Наименование файла образца
		 * @param array $replace - Заменяемые значения
		 * @param string $file - Полный путь к файлу
		 * @return void
		 */
		public static function generateFileAndSave(string $sample, array $replace, string $file): void {
			$content = self::generateFile($sample, $replace);

			self::saveFile($file, $content);
		}

		/**
		 * Генерирует содержимое файла
		 * @param string $sample - Наименование файла образца
		 * @param array $replace - Заменяемые значения
		 * @return string
		 */
		public static function generateFile(string $sample, array $replace): string {
			$content = file_get_contents(DIR_BASE . "craft/samples/{$sample}.sample");

			return str_replace(array_keys($replace), $replace, $content);
		}

		/**
		 * Сохраняет файл
		 * @param $file - Полный путь к файлу
		 * @param string $content - Содержимое файла
		 * @return void
		 */
		private static function saveFile($file, string $content): void {
			$info = pathinfo($file);

			if (!is_dir($info['dirname'])) mkdir($info['dirname'], 0777, true);
			file_put_contents("{$info['dirname']}/{$info['basename']}", $content);
		}

		/**
		 * Ищет во флагах наименование признака и возвращает его
		 * @param array $flags - Перечень флагов
		 * @return string|null
		 */
		public static function getFeatureFromFlags(array $flags): ?string {
			$list = self::getListParamsFlagsByName($flags, ['feature', 'f']);

			return isset($list[0][0]) ? strtolower($list[0][0]) : null;
		}

		/**
		 * Ищет во флагах наименование базы данных и возвращает его
		 * @param array $flags - Перечень флагов
		 * @return string|null
		 */
		public static function getBDFromFlags(array $flags): ?string {
			$list = self::getListParamsFlagsByName($flags, ['database', 'db']);

			return isset($list[0][0]) ? strtolower($list[0][0]) : null;
		}

		/**
		 * Ищет во флагах перечень таблиц и возвращает их
		 * @param array $flags - Перечень флагов
		 * @return array
		 */
		public static function getTablesFromFlags(array $flags): array {
			$tables = [];

			foreach (self::getListParamsFlagsByName($flags, ['table', 't']) as $params) {
				foreach ($params as $param) {
					if (!$param) continue;
					$tables[] = strtolower($param);
				}
			}

			return $tables;
		}

		/**
		 * Ищет во флагах перечень прав и возвращает их
		 * @param array $flags - Перечень флагов
		 * @return array|null
		 */
		public static function getRightsFromFlags(array $flags): ?array {
			$defaultRights = [
				'access' => 'Назначение прав',
				'select' => 'Выборка',
				'browse' => 'Вывод',
				'create' => 'Создание',
				'update' => 'Изменение',
				'delete' => 'Удаление',
				'status' => 'Изменение состояния',
			];

			$rights = [];

			foreach (self::getListParamsFlagsByName($flags, ['right', 'r']) as $params) {
				foreach ($params as $param) {
					if (in_array($param, $rights)) continue;
					if ($param == 'all') {
						if (!in_array('access', $rights)) $rights[] = ['name' => 'access', 'title' => $defaultRights['access']];
						if (!in_array('select', $rights)) $rights[] = ['name' => 'select', 'title' => $defaultRights['select']];
						if (!in_array('browse', $rights)) $rights[] = ['name' => 'browse', 'title' => $defaultRights['browse']];
						if (!in_array('create', $rights)) $rights[] = ['name' => 'create', 'title' => $defaultRights['create']];
						if (!in_array('update', $rights)) $rights[] = ['name' => 'update', 'title' => $defaultRights['update']];
						if (!in_array('delete', $rights)) $rights[] = ['name' => 'delete', 'title' => $defaultRights['delete']];
						if (!in_array('status', $rights)) $rights[] = ['name' => 'status', 'title' => $defaultRights['status']];
						continue;
					}
					if (!in_array($param, array_keys($defaultRights))) { Message::error("Не найдено право '{$param}'"); return null; }
					$rights[] = ['name' => $param, 'title' => $defaultRights[$param]];
				}
			}

			return $rights;
		}

		/**
		 * Возвращает массив парамеры по имени флага
		 * @param array $flags - Перечень флагов
		 * @param array $names - Наименования
		 * @return array
		 */
		private static function getListParamsFlagsByName(array $flags, array $names): array {
			$out = [];

			foreach ($flags as $flag) {
				if (in_array($flag['name'], $names)) $out[] = $flag['params'];
			}

			return $out;
		}

		/**
		 * Проверяет наличие флага из перечня флагов
		 * @param array $flags - Перечень флагов
		 * @param array $names - Наименования
		 * @return bool
		 */
		public static function isFlag(array $flags, array $names): bool {
			foreach ($flags as $flag) {
				if (in_array($flag['name'], $names)) return true;
			}

			return false;
		}

	}