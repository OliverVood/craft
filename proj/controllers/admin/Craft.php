<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use Base\ControllerAccess;
	use Base\Data\Set;
	use Exception;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * @controller
	 */
	class Craft extends ControllerAccess {

		public function __construct() {
			parent::__construct(app()->features('craft'));
		}

		public function index(): void {

		}

		public function help(): void {

		}

		/**
		 * Создание
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param string $entity - Сущность
		 * @return void
		 */
		#[NoReturn] public function create(Set $data, string $entity): void {
			if (!$this->allow('update')) response()->forbidden(__('Не достаточно прав'));

			switch ($entity) {
				case 'controller': response()->section('content', view('admin.craft.controller.create')); break;
				default: app()->error(new Exception(__("Craft entity '{$entity}' not found")));
			}

			response()->history(linkRight('craft'), ['entity' => $entity, 'action' => 'create']);
			response()->ok();

//			dd('create');
			// проверка на права

//			$data = $data->defined()->all();
//
//			$command = $data['command'] ?? '';
//			$entity = $data['entity'] ?? '';
//			$name = $data['name'] ?? '';
//			$flags = $data['flags'] ?? [];
//
//			\Base\Craft\Craft::run($command, $entity, $name, $flags);
		}

		/**
		 * Запускает Craft
		 * @param Set $data - Пользовательские данные
		 * @param string $entity - Сущность
		 * @param string $action - Действие
		 * @return void
		 */
		#[NoReturn] public function run(Set $data, string $entity, string $action): void {
			if (!$this->allow('update')) response()->forbidden(__('Не достаточно прав'));

			$name = trim($data->defined('name')->string());
			$flags = $data->defined('flags')->data([]);

			if (!$name) response()->unprocessableEntity(__('Ошибка валидации'), ['name' => [__('Поле не заполнено')]]);

			require DIR_BASE . 'craft/Craft.php';

			[$state, $message] = \Base\Craft\Craft::run($entity, $action, $name, $flags);
			dump($state);
			dump($message);
			dd('stop!');
		}

	}