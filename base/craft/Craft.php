<?php

	declare(strict_types=1);

	namespace Base\Craft;

	require DIR_BASE . 'craft/Message.php';
	require DIR_BASE . 'craft/Helper.php';

	require DIR_BASE . 'craft/Structure.php';
	require DIR_BASE . 'craft/Feature.php';
	require DIR_BASE . 'craft/Controller.php';
	require DIR_BASE . 'craft/Middleware.php';
	require DIR_BASE . 'craft/Model.php';
	require DIR_BASE . 'craft/Editor.php';
	require DIR_BASE . 'craft/View.php';
	require DIR_BASE . 'craft/Component.php';

	/**
	 * Craft. Основной класс
	 */
	abstract class Craft {
		const VERSION					= '1.0.0';

		const ENTITY_STRUCTURE			= 'structure';
		const ENTITY_FEATURE			= 'feature';
		const ENTITY_MIDDLEWARE			= 'middleware';
		const ENTITY_CONTROLLER			= 'controller';
		const ENTITY_MODEL				= 'model';
		const ENTITY_EDITOR				= 'editor';
		const ENTITY_VIEW				= 'view';
		const ENTITY_COMPONENT			= 'component';

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
				case self::ENTITY_FEATURE: $state = Feature::run($command, $name, $flags); break;
				case self::ENTITY_MIDDLEWARE: $state = Middleware::run($command, $name, $flags); break;
				case self::ENTITY_CONTROLLER: $state = Controller::run($command, $name, $flags); break;
				case self::ENTITY_MODEL: $state = Model::run($command, $name, $flags); break;
				case self::ENTITY_EDITOR: $state = Editor::run($command, $name, $flags); break;
				case self::ENTITY_VIEW: $state = View::run($command, $name, $flags); break;
				case self::ENTITY_COMPONENT: $state = Component::run($command, $name, $flags); break;
				case self::ENTITY_STRUCTURE: $state = Structure::run($command, $name, $flags); break;
				default: Message::error("Сущность '{$entity}' не найдена");
			}

			return [$state, Message::get()];
		}

	}