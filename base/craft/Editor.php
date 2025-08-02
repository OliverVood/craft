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
			if ($name === '') { Message::error('Имя редактора не указано'); return false; }

			[$path, $namespace, $class, $namespaceSuffix] = Helper::generateClassInfo('Proj\Editors\Models', DIR_PROJ_EDITORS_MODELS, $name);
			if (!self::createModel($path, $namespace, $class, $namespaceSuffix, $flags)) return false;

			[$path, $namespace, $class, $namespaceSuffix] = Helper::generateClassInfo('Proj\Editors\Controllers', DIR_PROJ_EDITORS_CONTROLLERS, $name);
			if (!self::createController($path, $namespace, $class, $namespaceSuffix, $flags)) return false;

			Message::success("Редактор '{$namespace}\\{$class}' создан");

			return true;
		}

		/**
		 * Создаёт контроллер редактора
		 * @param string $path - Путь
		 * @param string $namespace - Пространство имён
		 * @param string $class - Класс
		 * @param string $namespaceSuffix - Суффикс пространства имён
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static private function createController(string $path, string $namespace, string $class, string $namespaceSuffix, array $flags): bool {
			if (!$feature = Helper::getFeatureFromFlags($flags)) { Message::error('Признак не указан'); return false; }

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
		 * @param string $namespaceSuffix - Суффикс пространства имён
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static private function createModel(string $path, string $namespace, string $class, string $namespaceSuffix, array $flags): bool {
			if (!$db = Helper::getBDFromFlags($flags)) { Message::error('База данных не указана'); return false; }
			if (!$tables = Helper::getTablesFromFlags($flags)) { Message::error('Таблица не указана'); return false; }

			$sample = 'editor_model';

			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
				'<DB_ALIAS>'						=> strtolower($db),
				'<TABLE_NAME>'						=> strtolower($tables[0]),
			];

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Модель редактора '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			return true;
		}

	}