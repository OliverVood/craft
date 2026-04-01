<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Locales;

	use Base\Editor\Actions\Browse;
	use Base\Editor\Actions\Create;
	use Base\Editor\Actions\Delete;
	use Base\Editor\Actions\Select;
	use Base\Editor\Actions\Update;
	use Base\Editor\Controller;
	use Proj\Editors\Models;

	/**
	 * Controller-editor
	 * @controller
	 */
	class Contexts extends Controller {
		public function __construct() {
			parent::__construct(feature('contexts'), 'locales.contexts');

			$this->names = [
				'name' => __('Name'),
				'state' => __('Status'),
			];

			/** @var Models\Locales\Contexts $model */ $model = $this->model();

			$this->initSelect();
			$this->initBrowse($model);
			$this->initCreate();
			$this->initUpdate($model);
			$this->initDelete();
		}

		private function initSelect(): void {
			$this->select = new Select($this);

			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->text('name', $this->names['name']);

			$this->select->text('title', 'List of contexts');
		}

		private function initBrowse(Models\Locales\Contexts $model): void {
			$this->browse = new Browse($this);

			$this->browse->fields()->browse->text('name', $this->names['name']);
			$this->browse->fields()->browse->fromArray('state', $this->names['state'], $model->getStates());

			$this->browse->text('title', 'Browse context');
			$this->browse->text('do', 'View');
			$this->browse->text('responseErrorNotFound', 'Context not found');
		}

		private function initCreate(): void {
			$this->create = new Create($this);

			$this->create->fields()->edit->text('name', $this->names['name']);

			$this->create->validate([
				'name' => ['required', 'trim', 'string', 'min:1', 'max:10', 'unique:craft,locales_contexts,name'],
			]);

			$this->create->text('title', 'Adding context');
			$this->create->text('do', 'Add');
			$this->create->text('btn', 'Add');
			$this->create->text('responseOk', 'Context added');
		}

		private function initUpdate(Models\Locales\Contexts $model): void {
			$this->update = new Update($this);

			$this->update->fields()->edit->text('name', $this->names['name']);
			$this->update->fields()->edit->select('state', $this->names['state'], [
				$model::STATE_ACTIVE => __('Active'),
				$model::STATE_INACTIVE => __('Inactive'),
			]);

			$this->update->validate([
				'name' => ['required', 'trim', 'string', 'min:1', 'max:10', 'unique:craft,locales_contexts,name'],
				'state' => ['required', 'int', 'in:' . implode(',', [$model::STATE_ACTIVE, $model::STATE_INACTIVE])],
			]);

			$this->update->text('title', 'Editing context');
			$this->update->text('responseErrorNotFound', 'Context not found');
			$this->update->text('responseOk', 'The context has been changed');
		}

		private function initDelete(): void {
			$this->delete = new Delete($this);

			$this->delete->text('responseOk', 'Context removed');
		}

	}
