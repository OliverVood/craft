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
		 * Ищет в перечне флагов наименование признака и возвращает его
		 * @param array $flags - Перечень флагов
		 * @return string|null
		 */
		public static function getFeatureFromFlags(array $flags): ?string {
			foreach ($flags as $flag) {
				if (preg_match('/^-(feature|f):(.*)$/', $flag, $matches)) return $matches[2] === '' ? null : strtolower($matches[2]);
			}

			return null;
		}

		/**
		 * Ищет в перечне флагов наименование базы данных и возвращает его
		 * @param array $flags - Перечень флагов
		 * @return string|null
		 */
		public static function getBDFromFlags(array $flags): ?string {
			foreach ($flags as $flag) {
				if (preg_match('/^-(database|db):(.*)$/', $flag, $matches)) return $matches[2] === '' ? null : strtolower($matches[2]);
			}

			return null;
		}

		/**
		 * Ищет в перечне флагов наименование таблиц и возвращает их
		 * @param array $flags - Перечень флагов
		 * @return array
		 */
		public static function getTablesFromFlags(array $flags): array {
			$tables = [];

			foreach ($flags as $flag) {
				if (preg_match('/^-(table|t):(.*)$/', $flag, $matches)) if ($matches[2] !== '') $tables[] =  $matches[2];
			}

			return $tables;
		}

		/**
		 * Ищет в перечне флагов наименование прав и возвращает их
		 * @param array $flags - Перечень флагов
		 * @return array
		 */
		public static function getRightsFromFlags(array $flags): array {
			foreach ($flags as $flag) {
				if (preg_match('/^-(rights):(.*)$/', $flag, $matches)) return $matches[2] === '' ? [] : explode(',', $matches[2]);
			}

			return [];
		}

	}