<?php

	declare(strict_types=1);

	namespace Base\Craft;

	abstract class Component {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для компонентов
		 * @param string $command - Команда
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static public function run(string $command, string $name, array $flags): bool {
			switch ($command) {
				case self::COMMAND_CREATE: return self::create($name, $flags);
				default: Message::error("Команда {$command}' не найдена"); return false;
			}
		}

		/**
		 * Создаёт компонент
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static public function create(string $name, array $flags = []): bool {
			if ($name === '') { Message::error('Имя компонента не указано'); return false; }

			preg_match('/^((.*)\.)?(.+)$/', $name, $matches);

			$path = 'proj/ui/views/components/' . Helper::generatePath($matches[2]);
			$name = $matches[3];

			$sample = 'view';
			$replace = [
				'<NAME>'							=> $name,
			];

			$file = "{$path}{$name}.php";

			if (file_exists($file)) { Message::error("Компонент '{$file}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			Message::success("Компонент '{$file}' создан");

			return true;
		}

	}