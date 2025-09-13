<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Работа с редакторами
	 */
	abstract class Editor {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для редакторов
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
		 * Создаёт редактор
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static private function create(string $name, array $flags = []): bool {
			$db = Helper::getBDFromFlags($flags);
			$table = ($tables = Helper::getTablesFromFlags($flags)) ? $tables[0] : '';

			if ($name === '') { Message::error(__('Ошибка валидации данных'), ['name' => [__('Псевдоним редактора не указан')]]); return false; }
			if (!$feature = Helper::getFeatureFromFlags($flags)) { Message::error(__('Ошибка валидации данных'), ['feature' => [__('Псевдоним признака не указан')]]); return false; }
			if (!$db) { Message::error(__('Ошибка валидации данных'), ['database' => [__('База данных не указана')]]); return false; }
			if (!$table)  { Message::error(__('Ошибка валидации данных'), ['table' => [__('Таблица не указана')]]); return false; }

			[$path, $namespace, $class] = Helper::generateClassInfo('Proj\Editors\Models', DIR_PROJ_EDITORS_MODELS, $name);
			if (!self::createModel($path, $namespace, $class, $db, $table)) return false;

			[$path, $namespace, $class, $namespaceSuffix] = Helper::generateClassInfo('Proj\Editors\Controllers', DIR_PROJ_EDITORS_CONTROLLERS, $name);
			if (!self::createController($path, $namespace, $class, $namespaceSuffix, $feature)) return false;

			Message::success("Редактор '{$namespace}\\{$class}' создан");

			return true;
		}

		/**
		 * Создаёт контроллер редактора
		 * @param string $path - Путь
		 * @param string $namespace - Пространство имён
		 * @param string $class - Класс
		 * @param string $namespaceSuffix - Суффикс пространства имён
		 * @param string $feature - Признак
		 * @return bool
		 */
		static private function createController(string $path, string $namespace, string $class, string $namespaceSuffix, string $feature): bool {
			$sample = 'editor_controller';

			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
				'<FEATURE_NAME>'					=> $feature,
				'<MODEL_NAME>'						=> strtolower($class),
				'<MODEL_NAMESPACE_PREFIX>'			=> "Proj\Editors\Models{$namespaceSuffix}",
				'<MODEL_CLASS>'						=> $class,
			];

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Контроллер редактора '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			return true;
		}

		/**
		 * Создаёт модель редактора
		 * @param string $path - Путь
		 * @param string $namespace - Пространство имён
		 * @param string $class - Класс
		 * @param string $db - База данных
		 * @param string $table - Таблица
		 * @return bool
		 */
		static private function createModel(string $path, string $namespace, string $class, string $db, string $table): bool {
			$sample = 'editor_model';

			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
				'<DB_ALIAS>'						=> strtolower($db),
				'<TABLE_NAME>'						=> strtolower($table),
			];

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Модель редактора '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			return true;
		}

	}