<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use Base\Helper\Accumulator;
	use Closure;
	use Exception;

	/**
	 * Action create
	 */
	class Create {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;
		use Traits\Validation;

		private Controller $controller;

		public Closure $fnPrepareView;
		public Closure $fnPrepareData;
		public Closure $fnGetLinksNavigate;

		private string $tpl = 'admin.editor.create';

		/**
		 * @param Controller $controller - Controller
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'create';

			$this->fields = new Fields();

			$this->text('title', 'Creation');
			$this->text('do', 'Create');
			$this->text('btn', 'Create');
			$this->text('responseErrorAccess', 'Insufficient permissions');
			$this->text('responseErrorValidate', 'Data validation error');
			$this->text('responseErrorCreate', 'Saving error');
			$this->text('responseOk', 'Created');

			$this->fnGetLinksNavigate = fn () => $this->getLinksNavigate();
			$this->fnPrepareView = fn (array & $item) => $this->prepareView($item);
			$this->fnPrepareData = fn (array & $item) => $this->prepareData($item);
		}

		/**
		 * Returns the created block
		 * @return void
		 */
		public function get(): void {
			if (!$this->allow()) {
				response()->forbidden($this->__('responseErrorAccess'));
				return;
			}

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
		 * Creation
		 * @param Set $data - User data
		 * @return void
		 */
		public function set(Set $data): void {
			if (!$this->allow()) {
				response()->forbidden($this->__('responseErrorAccess'));
				return;
			}

			/** @var Model $model */ $model = $this->controller->model();

			$data = $data->defined()->all();
			$prepareData = $this->fnPrepareData;
			$prepareData($data);

			$errors = [];
			if (!$validated = $this->validation($data, $errors)) {
				response()->unprocessableEntity($this->__('responseErrorValidate'), $errors);
				return;
			}
			if (!$id = $model->create($validated)) {
				response()->unprocessableEntity($this->__('responseErrorCreate'));
				return;
			}

			if (!$this->controller->browse->inside($id)) return;

			response()->created(null, $this->__('responseOk'));
		}

		/**
		 * Prepare data for view
		 * @param array $item - Data
		 * @return void
		 */
		private function prepareView(array & $item): void {  }

		/**
		 * Prepare data for creation
		 * @param array $data - Data
		 * @return void
		 */
		private function prepareData(array & $data): void {  }

		/**
		 * Returns navigate links
		 * @return Accumulator
		 */
		public function getLinksNavigate(): Accumulator {
			$links = new Accumulator();

			if (!$this->controller->select) app()->error(new Exception(__("The ':[action]' action is not implemented.", ['action' => 'select'])));

			if (!$this->controller->linkSelect) app()->error(new Exception(__("Link ':[link]' for editor is not defined", ['link' => 'select'])));

			if ($this->controller->linkSelect->allow()) $links->push($this->controller->linkSelect->hyperlink('<< ' . $this->controller->select->__('title'), array_merge(['page' => old('page')->int(1)], (array)$this->controller->params)));

			return $links;
		}

	}
