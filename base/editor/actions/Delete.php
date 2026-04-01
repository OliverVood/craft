<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Actions\Traits\Entree;
	use Base\Editor\Actions\Traits\Texts;
	use Base\Editor\Controller;
	use Base\Editor\Model;
	use Closure;

	/**
	 * Контроллер-редактор удаления
	 */
	class Delete {
		use Entree;
		use Texts;

		private Controller $controller;

		public Closure $fnPrepareData;

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'delete';

			$this->text('do', 'Удалить');
			$this->text('confirm', 'Удалить?');
			$this->text('responseErrorAccess', 'Недостаточно прав');
			$this->text('responseErrorNotFound', 'Элемент не найден');
			$this->text('responseErrorDelete', 'Ошибка удаления');
			$this->text('responseOk', 'Удалено');

			$this->fnPrepareData = fn (int $id) => $this->prepareData($id);
		}

		/**
		 * Удаление
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

			$prepareData = $this->fnPrepareData;
			$prepareData($id);

			if (!$model->delete($id)) {
				response()->unprocessableEntity($this->__('responseErrorDelete'));
				return;
			}

			$this->controller->select->inside(old('page')->int(1));
			response()->ok(null, $this->__('responseOk'));
		}

		/**
		 * Подготовка данных перед удалением
		 * @param int $id - Идентификатор
		 * @return void
		 */
		private function prepareData(int $id): void {  }

	}