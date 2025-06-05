<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Работа со структурами
	 */
	abstract class Structure {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для структур
		 * @param string $command - Команда
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static public function run(string $command, string $name, array $flags = []): bool {
			switch ($command) {
				case self::COMMAND_CREATE: return self::create($name, $flags);
				default: Message::error("Команда {$command}' не найдена"); return false;
			}
		}

		/**
		 * Создаёт структуру
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static private function create(string $name, array $flags = []): bool {
			$getDB = function($flags): ?string {
				foreach ($flags as $flag) {
					if (preg_match('/^-(database|db):(.*)$/', $flag, $matches)) return $matches[2] === '' ? null : strtolower($matches[2]);
				}

				return null;
			};

			$getTables = function($flags): array {
				$tables = [];

				foreach ($flags as $flag) {
					if (preg_match('/^-(table):(.*)$/', $flag, $matches)) if ($matches[2] !== '') $tables[] =  $matches[2];
				}

				return $tables;
			};

			if ($name === '') { Message::error('Имя структуры не указано'); return false; }
			if (!$db = $getDB($flags)) { Message::error('База данных не указана'); return false; }

			preg_match('/^((.*)\.)?(.+)$/', $name, $matches);

			[$path, $namespace] = Helper::generatePathAndNamespace('Proj\Structures', DIR_PROJ_STRUCTURES, $matches[2]);
			$class = Helper::generateClassName($matches[3]);

			$sample = 'structure';
			$replace = [
				'<DB_NAME>'							=> $db,
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
				'<PROPERTIES_TABLES>'				=> '',
				'<FIELDS_TABLES>'					=> '',
			];

			if ($tables = $getTables($flags)) {
				[$replace['<PROPERTIES_TABLES>'], $replace['<FIELDS_TABLES>']] = self::useTables($tables);
			}

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Структура '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			Message::success("Структура '{$namespace}\\{$class}' создана");

			return true;
		}

		/**
		 * Возвращает использование таблиц
		 * @param array $tables - Таблицы
		 * @return string[]
		 */
		static private function useTables(array $tables): array {
			$properties = [];
			$fields = [];

			foreach ($tables as $table) {
				$nameLower = strtolower($table);
				$nameUpper = Helper::generateClassName($table);

				$properties[] = Helper::generateFile('structure_property_table', ['<TABLE_NAME_UPERCASE>' => $nameUpper]);
				$fields[] = Helper::generateFile('structure_fields_table', ['<TABLE_NAME_UPERCASE>' => $nameUpper, '<TABLE_NAME_LOWERCASE>' => $nameLower]);
			}

			return ["\n" . implode("\n", $properties) . "\n", "\n\n" . implode("\n\n", $fields)];
		}

	}