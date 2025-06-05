<?php

	declare(strict_types=1);

	namespace Base\Craft;

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
				default: Message::error("Команда {$command}' не найдена"); return false;
			}
		}

		/**
		 * Создаёт модель
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static public function create(string $name, array $flags = []): bool {
			if ($name === '') { Message::error('Имя модели не указано'); return false; }

			preg_match('/^((.*)\.)?(.+)$/', $name, $matches);

			[$path, $namespace] = Helper::generatePathAndNamespace('Proj\Models', DIR_PROJ_MODELS, $matches[2]);
			$class = Helper::generateClassName($matches[3]);

			$sample = 'model';
			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
			];

			$getDB = function($flags): ?string {
				foreach ($flags as $flag) {
					if (preg_match('/^-(database|db):(.*)$/', $flag, $matches)) return $matches[2] === '' ? null : strtolower($matches[2]);
				}

				return null;
			};

			if ($db = $getDB($flags)) {
				$sample = 'model_with_db';

				$replace['<DB_NAME>']				= $db;
			}

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Модель '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			Message::success("Модель '{$namespace}\\{$class}' создана");

			return true;
		}

	}