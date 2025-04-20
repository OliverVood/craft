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

	/**
	 * Контроллер-редактор создания
	 */
	class Create {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;
		use Traits\Validation;

		private Controller $controller;

		public Closure $fnGetLinksNavigate;
		public Closure $fnPrepareView;
		public Closure $fnPrepareData;

		private string $tpl = 'admin.editor.create';

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'create';

			$this->fnGetLinksNavigate = fn () => $this->getLinksNavigate();
			$this->fnPrepareView = fn (array & $item) => $this->prepareView($item);
			$this->fnPrepareData = fn (array & $item) => $this->prepareData($item);

			$this->fields = new Fields();

			$this->text('title', 'Создание');
			$this->text('do', 'Создать');
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

			$prepareView = $this->fnPrepareView;
			$item = [];
			$prepareView($item);

			$title = $this->__('title');
			$fields = $this->fields();
			$action = $this->controller->linkDoCreate;
			$textBtn = $this->__('btn');
			$editor = $this->controller;

			response()->history($this->controller->linkCreate, (array)$this->controller->params);
			response()->section('content', view($this->tpl, compact('title', 'fields', 'item', 'action', 'textBtn', 'editor')));
			response()->ok();
		}

		/**
		 * Возвращает ссылки навигации
		 * @return Accumulator
		 */
		public function getLinksNavigate(): Accumulator {
			$links = new Accumulator();

			if ($this->controller->linkSelect->allow()) $links->push($this->controller->linkSelect->hyperlink('<< ' . $this->controller->select->__('title'), array_merge(['page' => old('page')->int(1)], (array)$this->controller->params)));

			return $links;
		}

		/**
		 * Подготовка данных для блока создания
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareView(array & $item): void {  }

		/**
		 * Создание
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function set(Set $data): void {
			if (!$this->allow()) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$data = $data->defined()->all();
			$prepareData = $this->fnPrepareData;
			$prepareData($data);

			$errors = [];
			if (!$validated = $this->validation($data, $errors)) response()->unprocessableEntity($this->__('responseErrorValidate'), $errors);
			if (!$id = $model->create($validated)) response()->unprocessableEntity($this->__('responseErrorCreate'));

			$this->controller->browse->inside($id);

			response()->created(null, $this->__('responseOk'));
		}

		/**
		 * Подготовка данных перед созданием
		 * @param array $data - Данные
		 * @return void
		 */
		private function prepareData(array & $data): void {  }

	}