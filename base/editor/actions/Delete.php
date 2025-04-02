<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Actions\Traits\Entree;
	use Base\Editor\Actions\Traits\Texts;
	use Base\Editor\Controller;
	use Base\Editor\Model;
	use JetBrains\PhpStorm\NoReturn;

	class Delete {
		use Entree;
		use Texts;

		private Controller $controller;

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'update';

			$this->text('confirm', 'Удалить?');
			$this->text('responseErrorAccess', 'Не достаточно прав');
			$this->text('responseErrorNotFound', 'Элемент не найден');
			$this->text('responseErrorDelete', 'Ошибка удаления');
			$this->text('responseOk', 'Удалено');
		}

		/**
		 * Удаление
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function set(Set $data): void {
			$id = $data->defined('id')->int(0);

			if ($id < 1) response()->notFound($this->__('responseErrorNotFound'));
			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$this->prepareData($id);

			if (!$model->delete($id)) response()->unprocessableEntity($this->__('responseErrorDelete'));

			$this->controller->actionSelect->inside(old('page')->int(1));
			response()->ok(null, $this->__('responseOk'));
		}

		/**
		 * Подготовка данных перед удалением
		 * @param int $id - Идентификатор
		 * @return void
		 */
		protected function prepareData(int $id): void {  }

	}