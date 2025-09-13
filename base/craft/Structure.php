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
				default: Message::error("Команда '{$command}' не найдена"); return false;
			}
		}

		/**
		 * Создаёт структуру
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static private function create(string $name, array $flags = []): bool {
			if ($name === '') { Message::error(__('Ошибка валидации данных'), ['name' => [__('Псевдоним структуры не указан')]]); return false; }
			if (!$db = Helper::getBDFromFlags($flags)) { Message::error(__('Ошибка валидации данных'), ['database' => [__('Псевдоним базы данных не указан')]]); return false; }

			[$path, $namespace, $class] = Helper::generateClassInfo('Proj\Structures', DIR_PROJ_STRUCTURES, $name);

			$sample = 'structure';
			$replace = [
				'<DB_ALIAS>'						=> $db,
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
				'<PROPERTIES_TABLES>'				=> '',
				'<FIELDS_TABLES>'					=> '',
			];

			if ($tables = Helper::getTablesFromFlags($flags)) {
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
				$properties[] = Helper::generateFile('structure_property_table', ['<TABLE_NAME>' => $table]);
				$fields[] = Helper::generateFile('structure_fields_table', ['<TABLE_NAME>' => $table]);
			}

			return ["\n" . implode("\n", $properties) . "\n", "\n\n" . implode("\n\n", $fields)];
		}

	}