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
			if ($name === '') { Message::error('Имя признака не указано'); return false; }

			[$path, $namespace, $class] = Helper::generateClassInfo('Proj\Features', DIR_PROJ_FEATURES, $name);

			$sample = 'feature';
			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
				'<RIGHTS>'							=> '',
			];

			if ($rights = Helper::getRightsFromFlags($flags)) {
				$rightsList = [
					'access' => 'Назначение прав',
					'select' => 'Выборка',
					'browse' => 'Вывод',
					'create' => 'Создание',
					'update' => 'Изменение',
					'delete' => 'Удаление',
					'status' => 'Изменение состояния',
				];
				if (in_array('all', $rights)) $rights = array_keys($rightsList);
				$rightsSample = "\t\t\t\$this->rights->registration(self::RIGHT_<KEY>_ID, self::RIGHT_<KEY>_NAME, __('<TITLE>'));";
				$rightsArray = [];
				foreach ($rights as $right) {
					if (!isset($rightsList[$right])) { Message::error("Не найдено право '{$right}'"); return false; }
					$rightsArray[] = str_replace(['<KEY>', '<TITLE>'], [strtoupper($right), $rightsList[$right]], $rightsSample);
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
