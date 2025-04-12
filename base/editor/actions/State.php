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
	 * Контроллер-редактор состояния
	 */
	class State {
		use Entree;
		use Texts;

		private Controller $controller;

		public Closure $fnPrepareData;

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'state';

			$this->fnPrepareData = fn (int $id, int $state) => $this->prepareData($id, $state);

			$this->text('do', 'Изменить состояние');
			$this->text('confirm', 'Изменить состояние?');
			$this->text('responseErrorAccess', 'Не достаточно прав');
			$this->text('responseErrorNotFound', 'Элемент не найден');
			$this->text('responseErrorValidate', 'Ошибка валидации данных');
			$this->text('responseErrorState', 'Ошибка установки состояния');
			$this->text('responseOk', 'Изменено состояние');
		}

		/**
		 * Изменение состояния
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function set(Set $data): void {
			$id = $data->defined('id')->int(0);
			$state = $data->defined('state')->int(0);

			if ($id < 1) response()->notFound($this->__('responseErrorNotFound'));
			if ($state < 1) response()->unprocessableEntity($this->text('responseErrorValidate'));

			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$prepareData = $this->fnPrepareData;
			$prepareData($id, $state);

			if (!$model->setState($id, $state)) response()->unprocessableEntity($this->__('responseErrorState'));

			$this->controller->select->inside(old('page')->int(1));
			response()->ok(null, $this->text('responseOk'));
		}

		/**
		 * Подготовка данных перед изменением состояния
		 * @param int $id - Идентификатор
		 * @param int $state - Состояние
		 * @return void
		 */
		private function prepareData(int $id, int $state): void {  }

	}