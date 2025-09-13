<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Работа с моделями
	 */
	abstract class Model {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для моделей
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
		 * Создаёт модель
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static public function create(string $name, array $flags = []): bool {
			if ($name === '') { Message::error(__('Ошибка валидации данных'), ['name' => [__('Псевдоним модели не указан')]]); return false; }

			[$path, $namespace, $class] = Helper::generateClassInfo('Proj\Models', DIR_PROJ_MODELS, $name);

			$sample = 'model';
			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
			];

			if ($db = Helper::getBDFromFlags($flags)) {
				$sample = 'model_with_db';

				$replace['<DB_ALIAS>']				= $db;
			}

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Модель '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			Message::success("Модель '{$namespace}\\{$class}' создана");

			return true;
		}

	}