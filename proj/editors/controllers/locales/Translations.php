<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Locales;

	use Base\Editor\Actions\Access;
	use Base\Editor\Actions\Browse;
	use Base\Editor\Actions\Create;
	use Base\Editor\Actions\Delete;
	use Base\Editor\Actions\Select;
	use Base\Editor\Actions\Status;
	use Base\Editor\Actions\Update;
	use Base\Editor\Controller;
	use Base\Editor\Fields;
	use Base\Helper\Accumulator;
	use Proj\Editors\Models;

	/**
	 * Controller-editor
	 * @controller
	 */
	class Translations extends Controller {
		public function __construct() {
			parent::__construct(feature('translations'), 'locales.translations');

//			$this->names = [];

//			/** @var \Proj\Editors\Models\Locales\Translations $model */ $model = $this->model();

			$this->initSelect();
//			$this->initBrowse();
//			$this->initCreate();
//			$this->initUpdate();
//			$this->initDelete();
//			$this->initStatus();
		}

		private function initSelect(): void {
			$this->select = new Select($this);

			$this->select->tpl = 'admin.editor.languages.select';

//			$this->select->fields()->browse->

			$this->select->text('title', 'List of translations');

//			$this->select->fnPrepareView = fn (Response & $item) => $this->prepareView($item);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
//			$this->select->fnGetLinksNavigate = fn () => $this->getLinksNavigate();
		}

//		private function initBrowse(): void {
//			$this->browse = new Browse($this);
//
//			$this->browse->fields()->browse->
//
//			$this->browse->text('title', 'Browse');
//			$this->browse->text('do', 'View');
//			$this->browse->text('responseErrorAccess', 'Insufficient permissions');
//			$this->browse->text('responseErrorNotFound', 'Element not found');
//
//			$this->browse->fnPrepareView = fn (int $id, array & $item) => $this->prepareView($id, $item);
//			$this->browse->fnGetLinksNavigate = fn (array $item) => $this->getLinksNavigate($item);
//		}

//		private function initCreate(): void {
//			$this->create = new Create($this);
//
//			$this->create->fields()->edit->
//
//			$this->create->validate([]);
//
//			$this->create->text('title', 'Creation');
//			$this->create->text('do', 'Create');
//			$this->create->text('btn', 'Create');
//			$this->create->text('responseErrorAccess', 'Insufficient permissions');
//			$this->create->text('responseErrorValidate', 'Data validation error');
//			$this->create->text('responseErrorCreate', 'Saving error');
//			$this->create->text('responseOk', 'Created');
//
//			$this->create->fnPrepareView = fn (array & $item) => $this->prepareView($item);
//			$this->create->fnPrepareData = fn (array & $item) => $this->prepareData($item);
//			$this->create->fnGetLinksNavigate = fn () => $this->getLinksNavigate();
//		}

//		private function initUpdate(): void {
//			$this->update = new Update($this);
//
//			$this->update->fields()->edit->
//
//			$this->update->validate([]);
//
//			$this->update->text('title', 'Editing');
//			$this->update->text('btn', 'Edit');
//			$this->update->text('do', 'Edit');
//			$this->update->text('responseErrorAccess', 'Insufficient permissions');
//			$this->update->text('responseErrorNotFound', 'Element not found');
//			$this->update->text('responseErrorValidate', 'Data validation error');
//			$this->update->text('responseErrorUpdate', 'Editing error');
//			$this->update->text('responseOk', 'Edited');
//
//			$this->update->fnPrepareView = fn (int $id, array & $item) => $this->prepareView($id, $item);
//			$this->update->fnPrepareData = fn (int $id, array & $item) => $this->prepareData($id, $item);
//			$this->update->fnGetLinksNavigate = fn (array $item) => $this->getLinksNavigate($item);
//		}

//		private function initDelete(): void {
//			$this->delete = new Delete($this);
//
//			$this->delete->text('do', 'Delete');
//			$this->delete->text('confirm', 'Delete?');
//			$this->delete->text('responseErrorAccess', 'Insufficient permissions');
//			$this->delete->text('responseErrorNotFound', 'Element not found');
//			$this->delete->text('responseErrorDelete', 'Error deleting');
//			$this->delete->text('responseOk', 'Deleted');
//
//			$this->delete->fnPrepareData = fn (int $id) => $this->prepareData($id);
//		}

//		private function initStatus(): void {
//			$this->status = new Status($this);
//
//			$this->status->text('do', 'Change status');
//			$this->status->text('confirm', 'Change status?');
//			$this->status->text('responseErrorAccess', 'Insufficient permissions');
//			$this->status->text('responseErrorNotFound', 'Element not found');
//			$this->status->text('responseErrorValidate', 'Data validation error');
//			$this->status->text('responseErrorState', 'Error setting status');
//			$this->status->text('responseOk', 'Status changed');
//
//			$this->status->fnPrepareData = fn (int $id, int $state) => $this->prepareData($id, $state);
//		}

		/**
		 * Returns manage links
		 * @param array $item - Data
		 * @return Accumulator
		 */
		private function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

//			$id = isset($item['id']) ? (int)$item['id'] : 0;
//
//			if (!$this->controller->delete) app()->error(new Exception(__("The ':[action]' action is not implemented.", ['action' => 'delete'])));
//
//			if (!$this->controller->linkDelete) app()->error(new Exception(__("Link ':[link]' for editor is not defined", ['link' => 'delete'])));
//
//			if ($this->controller->linkDelete->allow()) $links->push($this->controller->linkDelete->linkHrefID($id, $this->controller->delete->__('do'), array_merge($item, (array)$this->controller->params)));

			return $links;
		}

	}
