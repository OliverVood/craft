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
	 * Контроллер-редактор просмотра
	 */
	class Browse {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;

		private Controller $controller;

		public Closure $fnGetLinksNavigate;
		public Closure $fnPrepareView;

		private string $tpl = 'admin.editor.browse';

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'browse';

			$this->fnGetLinksNavigate = fn (array $item) => $this->getLinksNavigate($item);
			$this->fnPrepareView = fn (int $id, array & $item) => $this->prepareView($id, $item);

			$this->fields = new Fields();

			$this->text('title', 'Просмотр');
			$this->text('do', 'Просмотреть');
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
			$prepareView = $this->fnPrepareView;
			$prepareView($id, $item);

			if (!$item) response()->unprocessableEntity($this->__('responseErrorNotFound'));

			$title = $this->__('title') . " #{$id}";
			$fields = $this->fields();
			$editor = $this->controller;

			response()->history($this->controller->linkBrowse, array_merge(['id' => $id], (array)$this->controller->params));
			response()->section('content', view($this->tpl, compact('title', 'fields', 'id', 'item', 'editor')));
		}

		/**
		 * Возвращает ссылки навигации
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksNavigate(array $item): Accumulator {
			$links = new Accumulator();

			if ($this->controller->linkSelect->allow()) $links->push($this->controller->linkSelect->hyperlink('<< ' . $this->controller->select->__('title'), array_merge(['page' => old('page')->int(1)], (array)$this->controller->params)));

			return $links;
		}

		/**
		 * Подготовка данных для блока просмотра
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareView(int $id, array & $item): void {  }

	}