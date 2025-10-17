<?php

	declare(strict_types=1);

	const DIR_ROOT = __DIR__ . '/';

	require  __DIR__ . '/consts/dirs.php';

	require DIR_BASE . 'craft/Craft.php';
	require DIR_BASE . 'functions.php';
	require DIR_BASE_HELPER . 'Translation.php';

	/**
	 * Craft. Работа с командной строкой.
	 */
	abstract class Craft {
		/**
		 * Запускает интерпретатор
		 * @return void
		 */
		public static function run(): void {
			$command = $_SERVER['argv'][1] ?? '';
			$entity = $_SERVER['argv'][2] ?? '';
			$name = $_SERVER['argv'][3] ?? '';
			$flags = [];
			for ($i = 4; $i < count($_SERVER['argv']); $i++) {
				$param = $_SERVER['argv'][$i];
				if (!preg_match('/^--([a-zA-Z0-9]+)(:(.*))?$/', $param, $matches)) continue;

				$flags[] = ['name' => $matches[1], 'params' => isset($matches[3]) ? explode(',', $matches[3]) : []];
			}

			if ($command === 'help') { self::help(); return; }

			[$state, $messages] = \Base\Craft\Craft::run($entity, $command, $name, $flags);

			($state) ? Message::echo("\n\033[32mКоманда выполнена успешно\033[0m") : Message::echo("\n\033[31mВыполнение команды завершено с ошибкой\033[0m");

			foreach ($messages as $message) {
				switch ($message['type']) {
					case 'info': Message::info($message['message']); break;
					case 'success': Message::success($message['message']); break;
					case 'warning': Message::warning($message['message']); break;
					case 'error': Message::error($message['message']); if ($message['data']) { Message::echo(__('Подробнее:')); foreach ($message['data'] as $values) foreach ($values as $text) Message::info($text); } break;
				}
			}
		}

		/**
		 * Выводит сообщения помощника в консоль
		 * @return void
		 */
		private static function help(): void {
			Help::echo();
		}

	}

	/**
	 * Craft. Работа с помощником.
	 */
	abstract class Help {
		/**
		 * Выводит текст помощника
		 * @return void
		 */
		public static function echo(): void {
			self::start();

			self::elem(
				description: 'CALL A HELPER',
				command: [
					'command' => 'help',
				],
			);

			self::elem(
				description: 'CREATE A FEATURE',
				command: [
					'command' => 'create',
					'entity' => 'feature',
					'name' => '<name>',
				],
				flags: [
					[
						'flags' => ['right', 'r'],
						'params' => '<rights (access,select,browse,create,update,delete,status | all)>',
						'description' => 'add rights',
					],
				],
			);

			self::elem(
				description: 'CREATE A CONTROLLER',
				command: [
					'command' => 'create',
					'entity' => 'controller',
					'name' => '<name>',
				],
				flags: [
					[
						'flags' => ['model', 'm'],
						'params' => '<name>',
						'description' => 'add model',
					],
					[
						'flags' => ['database', 'db'],
						'params' => '<name>',
						'description' => 'add database in model',
					],
				],
			);

			self::elem(
				description: 'CREATE A MODEL',
				command: [
					'command' => 'create',
					'entity' => 'model',
					'name' => '<name>',
				],
				flags: [
					[
						'flags' => ['database', 'db'],
						'params' => '<name>',
						'description' => 'add database in model',
					],
				],
			);

			self::elem(
				description: 'CREATE A MIDDLEWARE',
				command: [
					'command' => 'create',
					'entity' => 'middleware',
					'name' => '<name>',
				],
			);

			self::elem(
				description: 'CREATE A EDITOR',
				command: [
					'command' => 'create',
					'entity' => 'editor',
					'name' => '<name>',
				],
				flags: [
					[
						'flags' => ['feature', 'f'],
						'params' => '<name>',
						'description' => 'use feature in editor',
					],
					[
						'flags' => ['database', 'db'],
						'params' => '<name>',
						'description' => 'use database in editor',
					],
					[
						'flags' => ['table', 't'],
						'params' => '<name>',
						'description' => 'use table in editor',
					],
				],
			);

			self::elem(
				description: 'CREATE A VIEW',
				command: [
					'command' => 'create',
					'entity' => 'view',
					'name' => '<name>',
				],
			);

			self::elem(
				description: 'CREATE A COMPONENT',
				command: [
					'command' => 'create',
					'entity' => 'component',
					'name' => '<name>',
				],
			);

			self::elem(
				description: 'CREATE A STRUCTURE',
				command: [
					'command' => 'create',
					'entity' => 'structure',
					'name' => '<name>',
				],
				flags: [
					[
						'flags' => ['database', 'db'],
						'params' => '<name>',
						'description' => 'use database in structure',
					],
					[
						'flags' => ['table', 't'],
						'params' => '<name>',
						'description' => 'use table in structure',
					],
				],
			);
		}

		/**
		 * Выводит начальный текст
		 * @return void
		 */
		private static function start(): void {
			$version = \Base\Craft\Craft::VERSION;

			Message::echo('');
			Message::echo(Paint::green('/**********************************************'));
			Message::echo(Paint::green('/*              CRAFT FRAMEWORK              */'));
			Message::echo(Paint::green("/*              VERSION {$version}                */"));
			Message::echo(Paint::green('**********************************************/'));
			Message::echo('');
			Message::echo('LIST OF COMMANDS FOR CRAFTS:');
		}

		/**
		 * Выводит элемент списка команд
		 * @param string $description - Описание команды
		 * @param array $command - Команда
		 * @param array $flags - Перечень флагов
		 * @return void
		 */
		private static function elem(string $description, array $command, array $flags = []): void {
			Message::echo('');
			self::description($description);
			self::command($command['command'], $command['entity'] ?? '', $command['name'] ?? '');
			if ($flags) {
				foreach ($flags as $flag) {
					self::flag($flag['flags'], $flag['params'] ?? '', $flag['description'] ?? '');
				}
			}
		}

		/**
		 * Выводит описание
		 * @param string $text - Текст описания
		 * @return void
		 */
		private static function description(string $text): void {
			Message::echo(Paint::blue("• {$text}:"));
		}

		/**
		 * Выводит команду
		 * @param string $command - Название
		 * @param string $entity - Сущность
		 * @param string $name - Наименование
		 * @return void
		 */
		private static function command(string $command, string $entity = '', string $name = ''): void {
			Message::echo(Paint::yellow('php'), ' ', Paint::red('craft'), ' ', Paint::green($command), ' ', Paint::orange($entity), ' ', Paint::red($name));
		}

		/**
		 * Выводит флаги
		 * @param array $flags - Перечень флагов
		 * @param string $params - Параметры
		 * @param string $description - Описание
		 * @return void
		 */
		private static function flag(array $flags, string $params = '', string $description = ''): void {
			foreach ($flags as & $flag) {
				$flag = Paint::turquoise("--{$flag}");
				if ($params) $flag .= ':' . Paint::red($params);
			}

			Message::echo('     ', implode(', ', $flags), " - {$description}");
		}

	}

	/**
	 * Craft. Работа с сообщениями
	 */
	abstract class Message {
		/**
		 * Выводит информационное сообщение
		 * @param string $message - Сообщение
		 * @return void
		 */
		public static function info(string $message): void {
			self::echo(Paint::blue('Информация:'), ' ', $message);
		}

		/**
		 * Выводит сообщение об успехе
		 * @param string $message - Сообщение
		 * @return void
		 */
		public static function success(string $message): void {
			self::echo(Paint::green('Успех:'), ' ', $message);
		}

		/**
		 * Выводит предупреждение
		 * @param string $message - Сообщение
		 * @return void
		 */
		public static function warning(string $message): void {
			self::echo(Paint::orange('Предупреждение:'), ' ', $message);
		}

		/**
		 * Выводит сообщение об ошибке
		 * @param string $message - Сообщение
		 * @return void
		 */
		public static function error(string $message): void {
			self::echo(Paint::red('Ошибка:'), ' ', $message);
		}

		/**
		 * Выводит сообщения в консоль
		 * @param string ...$messages - Сообщения
		 * @return void
		 */
		public static function echo(string ...$messages): void {
			foreach ($messages as $message) {
				echo $message;
			}

			echo "\n";
		}

	}

	/**
	 * Craft. Работа с покраской текста
	 */
	abstract class Paint {
		/**
		 * Покраска текста в синий цвет
		 * @param string $text - Сообщение
		 * @return string
		 */
		public static function blue(string $text): string {
			return self::color('blue', $text);
		}

		/**
		 * Покраска текста в зелёный цвет
		 * @param string $text - Сообщение
		 * @return string
		 */
		public static function green(string $text): string {
			return self::color('green', $text);
		}

		/**
		 * Покраска текста в оранжевый цвет
		 * @param string $text - Сообщение
		 * @return string
		 */
		public static function orange(string $text): string {
			return self::color('orange', $text);
		}

		/**
		 * Покраска текста в красный цвет
		 * @param string $text - Сообщение
		 * @return string
		 */
		public static function red(string $text): string {
			return self::color('red', $text);
		}

		/**
		 * Покраска текста в бирюзовый цвет
		 * @param string $text - Сообщение
		 * @return string
		 */
		public static function turquoise(string $text): string {
			return self::color('turquoise', $text);
		}

		/**
		 * Покраска текста в жёлтый цвет
		 * @param string $text - Сообщение
		 * @return string
		 */
		public static function yellow(string $text): string {
			return self::color('yellow', $text);
		}

		/**
		 * Покраска текста
		 * @param string $color - Цвет
		 * @param string $text - Сообщение
		 * @return string
		 */
		private static function color(string $color, string $text): string {
			$code = self::getColorCodeByName($color);
			return "\033[{$code}{$text}\033[0m";
		}

		/**
		 * Возвращает код цвета по наименованию
		 * @param string $name - Наименование цвета
		 * @return string
		 */
		private static function getColorCodeByName(string $name): string {
			return match ($name) {
				'blue' => '36m',
				'green' => '92m',
				'orange' => '33m',
				'red' => '31m',
				'turquoise' => '1;36m',
				'yellow' => '1;33m',
				default => '0m'
			};
		}

	}

	Craft::run();