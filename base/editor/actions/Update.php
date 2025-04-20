<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use Base\Helper\Accumulator;
	use Closure;
	use JetBrains\PhpStorm\NoReturn;

	class Update {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;
		use Traits\Validation;

		private Controller $controller;

		public Closure $fnGetLinksNavigate;
		public Closure $fnPrepareView;
		public Closure $fnPrepareData;

		private string $tpl = 'admin.editor.update';

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'update';

			$this->fnGetLinksNavigate = fn (array $item) => $this->getLinksNavigate($item);
			$this->fnPrepareView = fn (int $id, array & $item) => $this->prepareView($id, $item);
			$this->fnPrepareData = fn (int $id, array & $item) => $this->prepareData($id, $item);

			$this->fields = new Fields();

			$this->text('title', 'Редактирование');
			$this->text('btn', 'Изменить');
			$this->text('do', 'Изменить');
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
			$prepareView = $this->fnPrepareView;
			$prepareView($id, $item);

			$title = $this->__('title') . " #{$id}";
			$fields = $this->fields();
			$action = $this->controller->linkDoUpdate;
			$textBtn = $this->__('btn');
			$editor = $this->controller;

			response()->history($this->controller->linkUpdate, array_merge(['id' => $id], (array)$this->controller->params));
			response()->section('content', view($this->tpl, compact('title', 'fields', 'id', 'item', 'action', 'textBtn', 'editor')));
			response()->ok();
		}

		/**
		 * Возвращает ссылки навигации
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksNavigate(array $item): Accumulator {
			$links = new Accumulator();

			if ($this->controller->linkSelect->allow()) $links->push($this->controller->linkSelect->hyperlink('<< ' . __($this->controller->select->text('title')), ['page' => old('page')->int(1)]));

			return $links;
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
			$prepareData = $this->fnPrepareData;
			$prepareData($id, $data);

			$errors = [];
			if (!$validated = $this->validation($data, $errors)) response()->unprocessableEntity($this->__('responseErrorValidate'), $errors);

			if (!$model->update($validated, $id)) response()->unprocessableEntity($this->__('responseErrorUpdate'));

			$this->controller->browse->inside($id);

			response()->ok(null, $this->__('responseOk'));
		}

		/**
		 * Подготовка данных перед изменением
		 * @param int $id - Идентификатор
		 * @param array $data - Данные
		 * @return void
		 */
		private function prepareData(int $id, array & $data): void {  }

	}