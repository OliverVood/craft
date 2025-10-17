<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Site;

	use Base\Controller;
	use Base\Data\Set;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models;

	/**
	 * Отвечает за обработку запросов к статистике
	 * @controller
	 */
	class Statistics extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Добавляет в статистику действия пользователя
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function actions(Set $data): void {
			$errors = [];
			$validated = validation($data->defined()->all(), [
				'object' => ['string', 'required'],
				'action' => ['string', 'required'],
				'params' => ['json'],
			], [], $errors);

			/** @var Models\Clients $clients */ $clients = model('clients');
			/** @var Models\Statistics $statistics */ $statistics = model('statistics');
			$statistics->addActions($clients->getId(), ...$validated);

			response()->ok();
		}

	}