<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Работа с отображениями
	 */
	abstract class View {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для отображений
		 * @param string $command - Команда
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static public function run(string $command, string $name, array $flags): bool {
			switch ($command) {
				case self::COMMAND_CREATE: return self::create($name, $flags);
				default: Message::error("Команда '{$command}' не найдена"); return false;
			}
		}

		/**
		 * Создаёт отображение
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static public function create(string $name, array $flags = []): bool {
			if ($name === '') { Message::error(__('Ошибка валидации данных'), ['name' => [__('Псевдоним отображения не указан')]]); return false; }

			preg_match('/^((.*)\.)?(.+)$/', $name, $matches);

			$path = 'proj/ui/views/' . ($matches[2] ? Helper::generatePath($matches[2]) : '');
			$name = $matches[3];

			$sample = 'view';
			$replace = [
				'<NAME>'							=> $name,
			];

			$file = "{$path}{$name}.tpl";

			if (file_exists($file)) { Message::error("Отображение '{$file}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			Message::success("Отображение '{$file}' создано");

			return true;
		}

	}