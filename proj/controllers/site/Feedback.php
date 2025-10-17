<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Site;

	use Base\Controller;
	use Base\Data\Set;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models;

	/**
	 * Отвечает за обработку запросов к обратной связи
	 * @controller
	 */
	class Feedback extends Controller {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Возвращает HTML-форму обратной связи
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function index(): void {
			response()->ok(
				['html' => view('site.feedback.form')]
			);
		}

		/**
		 * Сохраняет обратную связь
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function create(Set $data): void {
			$data = $data->defined()->all();

			$errors = [];
			if (!$validated = validation($data, [
				'name' => ['string', 'trim', 'required', 'max:255'],
				'contacts' => ['string', 'max:255'],
				'letter' => ['string', 'max:255'],
				'content' => ['string', 'trim', 'required'],
			], [], $errors)) response()->unprocessableEntity(__('Error validation'), $errors);

			/** @var Models\Feedback $feedback */ $feedback = model('feedback');

			$validated['state'] = $feedback::STATE_NEW;

			$feedback->create($validated);

			response()->ok();
		}

	}