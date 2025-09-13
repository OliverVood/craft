<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Работа с контроллерами
	 */
	abstract class Controller {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для контроллеров
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
		 * Создаёт контроллер
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static private function create(string $name, array $flags = []): bool {
			if ($name === '') { Message::error(__('Ошибка валидации данных'), ['name' => [__('Псевдоним контроллера не указан')]]); return false; }

			[$path, $namespace, $class, $namespaceSuffix] = Helper::generateClassInfo('Proj\Controllers', DIR_PROJ_CONTROLLERS, $name);

			$sample = 'controller';

			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
			];

			if (Helper::isFlag($flags, ['model', 'm'])) {
				if (!Model::create($name, $flags)) return false;

				$sample = 'controller_with_model';

				$replace['<MODEL_USE>']				= "Proj\Models{$namespaceSuffix}";
				$replace['<MODEL_NAME>']			= lcfirst($class);
			}

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Контроллер '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			Message::success("Контроллер '{$namespace}\\{$class}' создан");

			return true;
		}

	}