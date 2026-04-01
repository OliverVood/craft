<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Locales;

	use Base\Controller;
//	use Base\Data\Set;
//	use Proj\Models\Locales\Translations as Model;

	/**
	 * Controller
	 * @controller
	 */
	class Translations extends Controller {
		public function __construct() {
			parent::__construct();
		}

//		/**
//		 * Method
//		 * @controllerMethod
//		 * @param Set $data - User data
//		 * @return void
//		 */
//		public function example(Set $data): void {
//			$data = $data->defined()->all();
//
//			$errors = [];
//			if (!$validated = validation($data, [], [], $errors)) {
//				response()->unprocessableEntity(__('Error validation'), $errors);
//				return;
//			}
//
//			/** @var Model $model */ $model = model('translations');
//
//			if (!$model->example($validated)) {
//				response()->unprocessableEntity('error');
//				return;
//			}
//
//			response()->ok();
//		}

	}