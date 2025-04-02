<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use JetBrains\PhpStorm\NoReturn;

	class Create {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;

		private Controller $controller;

		private string $tpl = 'admin.editor.create';

		private array $validate = [];

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'create';

			$this->fields = new Fields();

			$this->text('title', 'Создание');
			$this->text('btn', 'Создать');
			$this->text('responseErrorAccess', 'Не достаточно прав');
			$this->text('responseErrorValidate', 'Ошибка валидации данных');
			$this->text('responseErrorCreate', 'Ошибка сохранения');
			$this->text('responseOk', 'Создано');
		}

		/**
		 * Возвращает блок создания
		 * @return void
		 */
		#[NoReturn] public function get(): void {
			if (!$this->allow()) response()->forbidden($this->__('responseErrorAccess'));

			$this->prepareView();

			$title = $this->__('title');
			$fields = $this->fields();
			$action = $this->controller->do_create;
			$textBtn = $this->__('btn');
			$editor = $this->controller;

			response()->history($this->controller->create);
			response()->section('content', view($this->tpl, compact('title', 'fields', 'action', 'textBtn', 'editor')));
			response()->ok();
		}

		/**
		 * Подготовка данных для блока создания
		 * @return void
		 */
		private function prepareView(): void {  }

		/**
		 * Создание
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function set(Set $data): void {
			if (!$this->allow()) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$data = $data->defined()->all();

			$this->prepareData($data);

			$errors = [];
			if (!$validated = $this->validation($data, $errors)) response()->unprocessableEntity($this->__('responseErrorValidate'), $errors);
			if (!$id = $model->create($validated)) response()->unprocessableEntity($this->__('responseErrorCreate'));

			$this->controller->actionBrowse->inside($id);

			response()->created(null, $this->__('responseOk'));
		}

		/**
		 * Подготовка данных перед созданием
		 * @param array $data - Данные
		 * @return void
		 */
		private function prepareData(array & $data): void {  }

		/**
		 * Возвращает/устанавливает правила валидации
		 * @param array|null $rules - Правила
		 * @return array|null
		 */
		public function validate(?array $rules = null): ?array {
			if ($rules) $this->validate = $rules;

			return $this->validate;
		}

		/**
		 * Проверяет данные для создания
		 * @param array $data - Данные
		 * @param array $errors - Ошибки
		 * @return array|null
		 */
		private function validation(array $data, array & $errors): ?array {
			return validation($data, $this->validate(), $this->controller->names, $errors);
		}

	}