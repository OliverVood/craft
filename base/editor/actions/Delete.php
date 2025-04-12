<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Actions\Traits\Entree;
	use Base\Editor\Actions\Traits\Texts;
	use Base\Editor\Controller;
	use Base\Editor\Model;
	use Closure;
	use JetBrains\PhpStorm\NoReturn;

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

			$this->access = 'update';

			$this->fnPrepareData = fn (int $id) => $this->prepareData($id);

			$this->text('do', 'Удалить');
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

			$prepareData = $this->fnPrepareData;
			$prepareData($id);

			if (!$model->delete($id)) response()->unprocessableEntity($this->__('responseErrorDelete'));

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