<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Работа с признаками
	 */
	abstract class Feature {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для признаков
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
		 * Создаёт признак
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static private function create(string $name, array $flags = []): bool {
			if ($name === '') { Message::error(__('Ошибка валидации данных'), ['name' => [__('Псевдоним признака не указан')]]); return false; }

			[$path, $namespace, $class] = Helper::generateClassInfo('Proj\Features', DIR_PROJ_FEATURES, $name);

			$sample = 'feature';
			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
				'<RIGHTS>'							=> '',
			];

			$rights = Helper::getRightsFromFlags($flags);
			if ($rights === null) return false;
			if ($rights) {
				$rightsSample = "\t\t\t\$this->rights->registration(self::RIGHT_<KEY>_ID, self::RIGHT_<KEY>_NAME, __('<TITLE>'));";
				$rightsArray = [];
				foreach ($rights as $right) {
					$rightsArray[] = str_replace(['<KEY>', '<TITLE>'], [strtoupper($right['name']), $right['title']], $rightsSample);
				}
				$replace['<RIGHTS>'] = "\n\n" . implode("\n", $rightsArray);
			}

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Признак '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			Message::success("Признак '{$namespace}\\{$class}' создан");

			return true;
		}

	}
