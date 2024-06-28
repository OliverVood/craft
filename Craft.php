<?php

	abstract class Craft {
		const ENTITY_CONTROLLER			= 'controller';
		const ENTITY_MODEL				= 'model';
		const ENTITY_TEMPLATE			= 'template';

		public static function run(): void {
			$command = $_SERVER['argv'][1] ?? null;
			$entity = $_SERVER['argv'][2] ?? null;
			$object = $_SERVER['argv'][3] ?? null;
			$flag = []; for ($i = 4; $i < count($_SERVER['argv']); $i++) $flag[] = $_SERVER['argv'][$i];

			switch ($entity) {
				case self::ENTITY_CONTROLLER: Controller::run($command, $object, $flag); break;
				default: Message::edge('Объект не существует');
			}
		}

	}

	abstract class Controller {
		const COMMAND_CREATE			= 'create';
		const COMMAND_UPDATE			= 'update';
		const COMMAND_DELETE			= 'delete';

		static public function run(string $command, string $object, array $flag) {
			switch ($command) {
				case self::COMMAND_CREATE: self::create($object, $flag); break;
				case self::COMMAND_UPDATE: self::update($object, $flag); break;
				case self::COMMAND_DELETE: self::delete($object, $flag); break;
				default: Message::edge('Команда не найдена');
			}
		}

		static private function create(string $name, array $flag) {
			Message::success("Контроллер `{$name}` создан");
		}

		static private function update(string $name, array $flag) {
			Message::success("Контроллер `{$name}` обновлён");
		}

		static private function delete(string $name, array $flag) {
			Message::success("Контроллер `{$name}` удалён");
		}

	}

	abstract class Message {
		public static function echo(string $message): void {
			echo "{$message}\n";
		}

		public static function success(string $message): void {
			self::echo("Успех: {$message}");
		}

		public static function error(string $message): void {
			self::echo("Ошибка: {$message}");
		}

		public static function edge(string $message): void {
			self::error("Ошибка: {$message}");
			die;
		}

	}

	Craft::run();