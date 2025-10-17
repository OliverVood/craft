<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Работа с промежуточными программными обеспечениями
	 */
	abstract class Middleware {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для промежуточных программных обеспечений
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
		 * Создаёт промежуточное программное обеспечение
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static private function create(string $name, array $flags = []): bool {
			if ($name === '') { Message::error(__('Ошибка валидации данных'), ['name' => [__('Псевдоним промежуточного программного обеспечения не указан')]]); return false; }

			[$path, $namespace, $class, ] = Helper::generateClassInfo('Proj\Middlewares', DIR_PROJ_MIDDLEWARES, $name);

			$sample = 'middleware';

			$replace = [
				'<NAMESPACE>'						=> $namespace,
				'<CLASS>'							=> $class,
			];

			$file = "{$path}{$class}.php";

			if (file_exists($file)) { Message::error("Промежуточное программное обеспечение '{$namespace}\\{$class}' уже существует"); return false; }

			Helper::generateFileAndSave($sample, $replace, $file);

			Message::success("Промежуточное программное обеспечение '{$namespace}\\{$class}' создано");

			return true;
		}

	}