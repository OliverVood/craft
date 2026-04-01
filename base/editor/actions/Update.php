<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use Base\Helper\Accumulator;
	use Closure;

	class Update {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;
		use Traits\Validation;

		private Controller $controller;

		public Closure $fnPrepareView;
		public Closure $fnPrepareData;
		public Closure $fnGetLinksNavigate;

		private string $tpl = 'admin.editor.update';

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'update';

			$this->fields = new Fields();

			$this->text('title', 'Редактирование');
			$this->text('btn', 'Изменить');
			$this->text('do', 'Изменить');
			$this->text('responseErrorAccess', 'Недостаточно прав');
			$this->text('responseErrorNotFound', 'Элемент не найден');
			$this->text('responseErrorValidate', 'Ошибка валидации данных');
			$this->text('responseErrorUpdate', 'Ошибка обновления');
			$this->text('responseOk', 'Изменено');

			$this->fnGetLinksNavigate = fn (array $item) => $this->getLinksNavigate($item);
			$this->fnPrepareView = fn (int $id, array & $item) => $this->prepareView($id, $item);
			$this->fnPrepareData = fn (int $id, array & $item) => $this->prepareData($id, $item);
		}

		/**
		 * Возвращает блок обновления
		 * @param Set $data - Пользовательские данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		public function get(Set $data, int $id): void {
			if ($id < 1) {
				response()->notFound($this->__('responseErrorNotFound'));
				return;
			}
			if (!$this->allow($id)) {
				response()->forbidden($this->__('responseErrorAccess'));
				return;
			}

			/** @var Model $model */ $model = $this->controller->model();

			if (!$item = $model->browse($id, ['*'])) {
				response()->unprocessableEntity($this->__('responseErrorNotFound'));
				return;
			}

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
		 * Обновление
		 * @param Set $data - Пользовательские данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		public function set(Set $data, int $id): void {
			if ($id < 1) {
				response()->notFound($this->__('responseErrorNotFound'));
				return;
			}
			if (!$this->allow($id)) {
				response()->forbidden($this->__('responseErrorAccess'));
				return;
			}

			/** @var Model $model */ $model = $this->controller->model();

			if (!$model->browse($id, ['*'])) {
				response()->unprocessableEntity($this->__('responseErrorNotFound'));
				return;
			}

			$data = $data->defined()->all();
			$data['id'] = $id;
			$prepareData = $this->fnPrepareData;
			$prepareData($id, $data);

			$errors = [];
			if (!$validated = $this->validation($data, $errors)) {
				response()->unprocessableEntity($this->__('responseErrorValidate'), $errors);
				return;
			}

			if (!$model->update($validated, $id)) {
				response()->unprocessableEntity($this->__('responseErrorUpdate'));
				return;
			}

			if (!$this->controller->browse->inside($id)) return;

			response()->ok(null, $this->__('responseOk'));
		}

		/**
		 * Подготовка данных для блока обновления
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareView(int $id, array & $item): void {  }

		/**
		 * Подготовка данных перед изменением
		 * @param int $id - Идентификатор
		 * @param array $data - Данные
		 * @return void
		 */
		private function prepareData(int $id, array & $data): void {  }

		/**
		 * Возвращает ссылки навигации
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksNavigate(array $item): Accumulator {
			$links = new Accumulator();

			if ($this->controller->linkSelect->allow()) $links->push($this->controller->linkSelect->hyperlink('<< ' . __($this->controller->select->text('title')), array_merge(['page' => old('page')->int(1)], (array)$this->controller->params)));

			return $links;
		}

	}
