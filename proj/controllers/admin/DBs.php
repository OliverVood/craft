<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use Base\ControllerAccess;
	use Base\Data\Set;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models;

	/**
	 * Работа с базой данных
	 * @controller
	 */
	class DBs extends ControllerAccess {
		public function __construct() {
			parent::__construct(app()->features('dbs'));
		}

		/**
		 * Возвращает структуру базы данных
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function structure(): void {
			if (!$this->allow('structure')) response()->forbidden(__('Не достаточно прав'));

			/** @var Models\DBs $dbs */ $dbs = model('dbs');

			$structure = $dbs->structure();

			response()->history(linkInternal('dbs_structure'));
			response()->section('content', view('admin.db.structure', compact('structure')));
			response()->ok();
		}

		/**
		 * Проверяет структуру базы данных
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function check(): void {
			if (!$this->allow('check')) response()->forbidden(__('Не достаточно прав'));

			/** @var Models\DBs $dbs */ $dbs = model('dbs');

			$data = $dbs->check();
			$action = linkInternal('dbs_make')->path();
			$csrf = app()->csrf();

			response()->history(linkInternal('dbs_check'));
			response()->section('content', view('admin.db.check', compact('data', 'action', 'csrf')));
			response()->ok();
		}

		/**
		 * Исправляет структуру базы данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function make(Set $data): void {
			if (!$this->allow('make')) response()->forbidden(__('Не достаточно прав'));

			/** @var Models\DBs $dbs */ $dbs = model('dbs');

			$data = $data->inputArray('tables')->data([]);

			if (!$dbs->make($data)) response()->unprocessableEntity(__('Ошибка выполнения'));

			$data = $dbs->check();
			$action = linkInternal('dbs_make')->path();

			response()->ok(compact('data', 'action'), __('База данных успешно обновлена'));
		}

	}