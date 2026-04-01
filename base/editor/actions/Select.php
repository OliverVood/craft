<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\DB\Response;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Editor\Model;
	use Base\Helper\Accumulator;
	use Base\Helper\Pagination;
	use Closure;
	use Exception;

	/**
	 * Action select
	 */
	class Select {
		use Traits\Entree;
		use Traits\Texts;
		use Traits\Fields;

		private Controller $controller;

		public Closure $fnPrepareView;
		public Closure $fnGetLinksManage;
		public Closure $fnGetLinksNavigate;

		public string $tpl = 'admin.editor.select';

		private int $page_entries = 10;

		/**
		 * @param Controller $controller - Controller
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'select';

			$this->fields = new Fields();

			$this->text('title', 'Selection');
			$this->text('responseErrorAccess', 'Insufficient permissions');

			$this->fnPrepareView = fn (mixed & $item) => $this->prepareView($item);
			$this->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->fnGetLinksNavigate = fn () => $this->getLinksNavigate();
		}

		/**
		 * Returns the select block
		 * @param Set $data - User data
		 * @return void
		 */
		public function get(Set $data): void {
			$page = $data->defined('page')->int(1);

			$this->inside($page);

			response()->ok();
		}

		/**
		 * Select block
		 * @param int $page - Page
		 * @return void
		 */
		public function inside(int $page): void {
			if (!$this->allow()) {
				response()->forbidden($this->__('responseErrorAccess'));
				return;
			}

			/** @var Model $model */ $model = $this->controller->model();

			[$items, $ext] = $model->select(['*'], $page, $this->page_entries, $this->controller->params);
			$prepareView = $this->fnPrepareView;
			$prepareView($items);

			$title = $this->__('title');
			$fields = $this->fields();
			$pagination = $this->page_entries ? new Pagination($this->controller->linkSelect, $ext['page']['current'], $ext['page']['count']) : null;
			$editor = $this->controller;

			response()->history($this->controller->linkSelect, array_merge(['page' => $page], (array)$this->controller->params));
			response()->section('content', view($this->tpl, compact('title', 'fields', 'items' ,'pagination', 'editor')));
		}

		/**
		 * Prepare data
		 * @param Response|array $items
		 * @return void
		 */
		private function prepareView(mixed & $items): void {  }

		/**
		 * Returns manage links
		 * @param array $item - Data
		 * @return Accumulator
		 */
		private function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$id = isset($item['id']) ? (int)$item['id'] : 0;

			if (!$this->controller->browse) app()->error(new Exception(__("The ':[action]' action is not implemented.", ['action' => 'browse'])));
			if (!$this->controller->update) app()->error(new Exception(__("The ':[action]' action is not implemented.", ['action' => 'update'])));
			if (!$this->controller->delete) app()->error(new Exception(__("The ':[action]' action is not implemented.", ['action' => 'delete'])));

			if (!$this->controller->linkBrowse) app()->error(new Exception(__("Link ':[link]' for editor is not defined", ['link' => 'browse'])));
			if (!$this->controller->linkUpdate) app()->error(new Exception(__("Link ':[link]' for editor is not defined", ['link' => 'update'])));
			if (!$this->controller->linkDelete) app()->error(new Exception(__("Link ':[link]' for editor is not defined", ['link' => 'delete'])));

			if ($this->controller->linkBrowse->allow()) $links->push($this->controller->linkBrowse->linkHrefID($id, $this->controller->browse->__('do'), array_merge($item, (array)$this->controller->params)));
			if ($this->controller->linkUpdate->allow()) $links->push($this->controller->linkUpdate->linkHrefID($id, $this->controller->update->__('do'), array_merge($item, (array)$this->controller->params)));
			if ($this->controller->linkDelete->allow()) $links->push($this->controller->linkDelete->linkHrefID($id, $this->controller->delete->__('do'), array_merge($item, (array)$this->controller->params)));

			return $links;
		}

		/**
		 * Returns navigate links
		 * @return Accumulator
		 */
		public function getLinksNavigate(): Accumulator {
			return new Accumulator();
		}

	}
