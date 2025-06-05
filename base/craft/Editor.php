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
				default: Message::error("Команда {$command}' не найдена"); return false;
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

			preg_match('/^((.*)\.)?(.+)$/', $name, $matches);

//			[$path, $namespace, $namespaceSuffix] = Helper::generatePathAndNamespace('Proj\Controllers', DIR_PROJ_CONTROLLERS, $matches[2]);
			$class = Helper::generateClassName($matches[3]);
//
//			$sample = 'controller';
//
//			$replace = [
//				'<NAMESPACE>'						=> $namespace,
//				'<CLASS>'							=> $class,
//			];
//
//			if (array_intersect(['-model', '-m'], $flags)) {
//				if (!Model::create($name, $flags)) return false;
//
//				$sample = 'controller_with_model';
//
//				$replace['<MODEL_USE>']				= "Proj\Models{$namespaceSuffix}";
//				$replace['<MODEL_NAME>']			= lcfirst($class);
//			}
//
//			$file = "{$path}{$class}.php";
//
//			if (file_exists($file)) { Message::error("Контроллер '{$namespace}\\{$class}' уже существует"); return false; }
//
//			Helper::generateFileAndSave($sample, $replace, $file);
//
//			Message::success("Контроллер '{$namespace}\\{$class}' создан");

			return true;
		}

	}