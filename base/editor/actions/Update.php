<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use JetBrains\PhpStorm\NoReturn;

	class Update {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;

		private Controller $controller;

		private string $tpl = 'admin.editor.update';

		private array $validate = [];

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'update';

			$this->fields = new Fields();

			$this->text('title', 'Редактирование');
			$this->text('btn', 'Изменить');
			$this->text('responseErrorAccess', 'Не достаточно прав');
			$this->text('responseErrorValidate', 'Ошибка валидации данных');
			$this->text('responseErrorNotFound', 'Элемент не найден');
			$this->text('responseErrorUpdate', 'Ошибка обновления');
			$this->text('responseOk', 'Изменено');
		}

		/**
		 * Возвращает блок обновления
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function get(Set $data): void {
			$id = $data->defined('id')->int(0);

			if ($id < 1) response()->notFound($this->__('responseErrorNotFound'));
			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$item = $model->browse($id, ['*']);
			$this->prepareView($id, $item);

			$title = $this->__('title') . " #{$id}";
			$fields = $this->fields();
			$action = $this->controller->do_update;
			$textBtn = $this->__('btn');
			$editor = $this->controller;

			response()->history($this->controller->update, ['id' => $id]);
			response()->section('content', view($this->tpl, compact('title', 'fields', 'id', 'item', 'action', 'textBtn', 'editor')));
			response()->ok();
		}

		/**
		 * Подготовка данных для блока обновления
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareView(int $id, array & $item): void {  }

		/**
		 * Обновление
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function set(Set $data): void {
			$id = $data->defined('id')->int(0);

			if ($id < 1) response()->notFound($this->__('responseErrorNotFound'));
			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$data = $data->defined()->all();
			$this->prepareData($data, $id);
			$errors = [];
			if (!$validated = $this->validation($data, $errors)) response()->unprocessableEntity($this->__('responseErrorValidate'), $errors);

			if (!$model->update($validated, $id)) response()->unprocessableEntity($this->__('responseErrorUpdate'));

			$this->controller->actionBrowse->inside($id);

			response()->ok(null, $this->__('responseOk'));
		}

		/**
		 * Подготовка данных перед изменением
		 * @param array $data - Данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		private function prepareData(array & $data, int $id): void {  }

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
		 * Проверяет данные для редактирования
		 * @param array $data - Данные
		 * @param array $errors - Ошибки
		 * @return array|null
		 */
		private function validation(array $data, array & $errors): ?array {
			return validation($data, $this->validate(), $this->controller->names, $errors);
		}

	}