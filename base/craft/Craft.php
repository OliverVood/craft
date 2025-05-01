<?php

	declare(strict_types=1);

	namespace Base\Craft;

	require DIR_BASE . 'craft/Message.php';

	require DIR_BASE . 'craft/Controller.php';
	require DIR_BASE . 'craft/Model.php';
	require DIR_BASE . 'craft/View.php';

	/**
	 * Craft. Основной класс
	 */
	abstract class Craft {
		const ENTITY_CONTROLLER			= 'controller';
		const ENTITY_MODEL				= 'model';
		const ENTITY_VIEW				= 'view';

		/**
		 * Запускает Craft
		 * @param string $entity - Сущность
		 * @param string $command - Команда
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return array
		 */
		static public function run(string $entity, string $command, string $name, array $flags): array {
			$state = false;
			switch ($entity) {
				case self::ENTITY_CONTROLLER: $state = Controller::run($command, $name, $flags); break;
				case self::ENTITY_MODEL: Model::run($command, $name, $flags); break;
				case self::ENTITY_VIEW: View::run($command, $name, $flags); break;
			}

			return [$state, Message::get()];
		}

	}