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

		public function index(): void {//todo
			dd('index');
		}

		public function help(): void {//todo
			dd('help');
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
				case 'feature':
				case 'structure':
				case 'controller':
				case 'model':
				case 'editor':
				case 'view':
				case 'component':
					response()->section('content', view("admin.craft.{$entity}.create")); break;
				default:
					app()->error(new Exception(__("Craft entity '{$entity}' not found")));
			}

			response()->history(linkRight('craft_action'), ['entity' => $entity, 'action' => 'create']);
			response()->ok();
		}

		/**
		 * Запускает Craft
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param string $entity - Сущность
		 * @param string $action - Действие
		 * @return void
		 */
		#[NoReturn] public function run(Set $data, string $entity, string $action): void {
			if (!$this->allow('update')) response()->forbidden(__('Не достаточно прав'));

			$name = trim($data->defined('name')->string());
			$params = $data->defined('params')->data([]);

			$flags = [];
			foreach ($params as $key => $value) {
				$flags[] = ['name' => $key, 'params' => is_array($value) ? $value : [$value]];
			}

			require DIR_BASE . 'craft/Craft.php';

			[, $messages] = \Base\Craft\Craft::run($entity, $action, $name, $flags);

			foreach ($messages as ['type' => $type, 'message' => $message, 'data' => $data]) {
				switch ($type) {
					case 'success': response()->noticeOk($message); break;
					case 'error': response()->noticeError($message, $data); break;
				}
			}

			response()->ok();
		}

	}