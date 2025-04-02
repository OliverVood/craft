<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use JetBrains\PhpStorm\NoReturn;

	class Browse {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;

		private Controller $controller;

		private string $tpl = 'admin.editor.browse';

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'browse';

			$this->fields = new Fields();

			$this->text('title', 'Просмотр');
			$this->text('responseErrorAccess', 'Не достаточно прав');
			$this->text('responseErrorNotFound', 'Элемент не найден');
		}

		/**
		 * Возвращает блок просмотра
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function get(Set $data): void {
			$id = $data->defined('id')->int(0);

			if ($id < 1) response()->notFound($this->__('responseErrorNotFound'));

			$this->inside($id);

			response()->ok();
		}

		/**
		 * Блок просмотра
		 * @param int $id - Идентификатор
		 * @return void
		 */
		public function inside(int $id): void {
			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$item = $model->browse($id, ['*']);

			$this->prepareView($id, $item);

			if (!$item) response()->unprocessableEntity($this->__('responseErrorNotFound'));

			$title = $this->__('title') . " #{$id}";
			$fields = $this->fields();
			$editor = $this->controller;

			response()->history($this->controller->browse, ['id' => $id]);
			response()->section('content', view($this->tpl, compact('title', 'fields', 'id', 'item', 'editor')));
		}

		/**
		 * Подготовка данных для блока просмотра
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareView(int $id, array & $item): void {  }

	}