<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use Base\ControllerAccess;
	use Base\Data\Set;
	use Exception;

	/**
	 * @controller
	 */
	class Craft extends ControllerAccess {

		public function __construct() {
			parent::__construct(feature('craft'));
		}

		/**
		 * Документация фреймворка
		 * @controllerMethod
		 * @return void
		 */
		public function documentation(): void {//todo
			response()->history(linkInternal('craft_documentation'));
			response()->section('content', view('admin.craft.documentation'));
			response()->ok();
		}

		/**
		 * Помощник командной строки
		 * @controllerMethod
		 * @return void
		 */
		public function help(): void {
			$head = [
				'/**********************************************',
				'/*              CRAFT FRAMEWORK              */',
				'/*              VERSION 1.0.0                */',
				'/**********************************************/',
			];

			$groups = [
				[
					'title' => 'Helper',
					'commands' => [
						[
							'title' => 'Call a helper',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'help'],
							],
						],
					],
				], [
					'title' => 'Feature',
					'commands' => [
						[
							'title' => 'Create',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'create'],
								['color' => 'orange', 'text' => 'feature'],
								['color' => 'red', 'text' => '&lt;name&gt;'],
							],
							'flags' => [
								[
									'name' => '--right',
									'additionally' => '&lt;rights (access,select,browse,create,update,delete,status | all)&gt;',
									'description' => 'add rights',
								], [
									'name' => '--r',
									'additionally' => '&lt;rights (access,select,browse,create,update,delete,status | all)&gt;',
									'description' => 'add rights',
								],
							]
						],
					],
				], [
					'title' => 'Controller',
					'commands' => [
						[
							'title' => 'Create',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'create'],
								['color' => 'orange', 'text' => 'controller'],
								['color' => 'red', 'text' => '&lt;name&gt;'],
							],
							'flags' => [
								[
									'name' => '--model',
									'additionally' => '&lt;name&gt;',
									'description' => 'add model',
								], [
									'name' => '--m',
									'additionally' => '&lt;name&gt;',
									'description' => 'add model',
								], [
									'name' => '--database',
									'additionally' => '&lt;name&gt;',
									'description' => 'add database in model',
								], [
									'name' => '--db',
									'additionally' => '&lt;name&gt;',
									'description' => 'add database in model',
								],
							],
						],
					],
				], [
					'title' => 'Model',
					'commands' => [
						[
							'title' => 'Create',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'create'],
								['color' => 'orange', 'text' => 'model'],
								['color' => 'red', 'text' => '&lt;name&gt;'],
							],
							'flags' => [
								[
									'name' => '--database',
									'additionally' => '&lt;name&gt;',
									'description' => 'add database in model',
								], [
									'name' => '--db',
									'additionally' => '&lt;name&gt;',
									'description' => 'add database in model',
								],
							],
						],
					],
				], [
					'title' => 'Middleware',
					'commands' => [
						[
							'title' => 'Create',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'create'],
								['color' => 'orange', 'text' => 'middleware'],
								['color' => 'red', 'text' => '&lt;name&gt;'],
							],
						],
					],
				], [
					'title' => 'Editor',
					'commands' => [
						[
							'title' => 'Create',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'create'],
								['color' => 'orange', 'text' => 'editor'],
								['color' => 'red', 'text' => '&lt;name&gt;'],
							],
							'flags' => [
								[
									'name' => '--feature',
									'additionally' => '&lt;name&gt;',
									'description' => 'use feature in editor',
								],
								[
									'name' => '--f',
									'additionally' => '&lt;name&gt;',
									'description' => 'use feature in editor',
								], [
									'name' => '--database',
									'additionally' => '&lt;name&gt;',
									'description' => 'use database in editor',
								], [
									'name' => '--db',
									'additionally' => '&lt;name&gt;',
									'description' => 'use database in editor',
								], [
									'name' => '--table',
									'additionally' => '&lt;name&gt;',
									'description' => 'use table in editor',
								], [
									'name' => '--t',
									'additionally' => '&lt;name&gt;',
									'description' => 'use table in editor',
								],
							],
						],
					],
				], [
					'title' => 'View',
					'commands' => [
						[
							'title' => 'Create',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'create'],
								['color' => 'orange', 'text' => 'view'],
								['color' => 'red', 'text' => '&lt;name&gt;'],
							],
						],
					],
				], [
					'title' => 'Component',
					'commands' => [
						[
							'title' => 'Create',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'create'],
								['color' => 'orange', 'text' => 'component'],
								['color' => 'red', 'text' => '&lt;name&gt;'],
							],
						],
					],
				], [
					'title' => 'Structure',
					'commands' => [
						[
							'title' => 'Create',
							'arguments' => [
								['color' => '', 'text' => 'php'],
								['color' => 'red', 'text' => 'craft'],
								['color' => 'green', 'text' => 'create'],
								['color' => 'orange', 'text' => 'structure'],
								['color' => 'red', 'text' => '&lt;name&gt;'],
							],
							'flags' => [
								[
									'name' => '--database',
									'additionally' => '&lt;name&gt;',
									'description' => 'use database in structure',
								], [
									'name' => '--db',
									'additionally' => '&lt;name&gt;',
									'description' => 'use database in structure',
								], [
									'name' => '--table',
									'additionally' => '&lt;name&gt;',
									'description' => 'use table in structure',
								], [
									'name' => '--t',
									'additionally' => '&lt;name&gt;',
									'description' => 'use table in structure',
								],
							],
						],
					],
				],
			];

			response()->history(linkInternal('craft_help'));
			response()->section('content', view('admin.craft.help', compact('head', 'groups')));
			response()->ok();
		}

		/**
		 * Создание
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param string $entity - Сущность
		 * @return void
		 */
		public function create(Set $data, string $entity): void {
			if (!$this->allow('update')) {
				response()->forbidden(__('Недостаточно прав'));
				return;
			}

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
		public function run(Set $data, string $entity, string $action): void {
			if (!$this->allow('update')) {
				response()->forbidden(__('Недостаточно прав'));
				return;
			}

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