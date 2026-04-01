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
	class Aliases extends Controller {
		public function __construct() {
			parent::__construct(feature('aliases'), 'locales.aliases');

			$this->names = [
				'context' => __('Context'),
				'name' => __('Alias'),
				'use_php' => __('use in PHP'),
				'use_js' => __('use in JavaScript'),
				'state' => __('Status'),
			];

			/** @var Models\Locales\Aliases $model */ $model = $this->model();

			$this->initSelect($model);
			$this->initBrowse($model);
			$this->initCreate($model);
			$this->initUpdate($model);
			$this->initDelete();
		}

		private function initSelect(Models\Locales\Aliases $model): void {
			$this->select = new Select($this);

			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->text('context_name', $this->names['context']);
			$this->select->fields()->browse->text('name', $this->names['name']);
			$this->select->fields()->browse->fromArray('use_php', $this->names['use_php'], $model->getUses());
			$this->select->fields()->browse->fromArray('use_js', $this->names['use_js'], $model->getUses());

			$this->select->text('title', 'List of aliases');
		}

		private function initBrowse(Models\Locales\Aliases $model): void {
			$this->browse = new Browse($this);

			$this->browse->fields()->browse->text('context_name', $this->names['context']);
			$this->browse->fields()->browse->text('name', $this->names['name']);
			$this->browse->fields()->browse->fromArray('use_php', $this->names['use_php'], $model->getUses());
			$this->browse->fields()->browse->fromArray('use_js', $this->names['use_js'], $model->getUses());

			$this->browse->text('title', 'View context');
			$this->browse->text('responseErrorNotFound', 'Context not found');
		}

		private function initCreate(Models\Locales\Aliases $model): void {
			$this->create = new Create($this);

			$this->create->fields()->edit->select('context', $this->names['context'], $this->getContexts(), ['empty' => ['key' => 0, 'value' => __('Выберите')]]);
			$this->create->fields()->edit->text('name', $this->names['name']);
			$this->create->fields()->edit->select('use_php', $this->names['use_php'], $model->getUses(), ['empty' => ['key' => 0, 'value' => __('Выберите')]]);
			$this->create->fields()->edit->select('use_js', $this->names['use_js'], $model->getUses(), ['empty' => ['key' => 0, 'value' => __('Выберите')]]);

			$this->create->validate([
				'context' => ['required', 'int', 'foreign:craft,locales_contexts,id'],
				'name' => ['required', 'trim', 'string', 'min:1', 'max:100', 'unique:craft,locales_aliases,name'],
				'use_php' => ['required', 'int', 'in:' . implode(',', [$model::USE_ACTIVE, $model::USE_INACTIVE])],
				'use_js' => ['required', 'int', 'in:' . implode(',', [$model::USE_ACTIVE, $model::USE_INACTIVE])],
			]);

			$this->create->text('title', 'Adding context');
			$this->create->text('btn', 'Add');
			$this->create->text('responseOk', 'Context added');

			$this->create->fnPrepareView = fn (array & $item) => $this->prepareView($item);
		}

		private function initUpdate(Models\Locales\Aliases $model): void {
			$this->update = new Update($this);

			$this->update->fields()->edit->select('context', $this->names['context'], $this->getContexts());
			$this->update->fields()->edit->text('name', $this->names['name']);
			$this->update->fields()->edit->select('use_php', $this->names['use_php'], $model->getUses());
			$this->update->fields()->edit->select('use_js', $this->names['use_js'], $model->getUses());

			$this->update->validate([
				'id' => ['required', 'int'],
				'context' => ['required', 'int', 'foreign:craft,locales_contexts,id'],
				'name' => ['required', 'trim', 'string', 'min:1', 'max:100', 'unique_current_exclude:craft,locales_aliases,name'],
				'use_php' => ['required', 'int', 'in:' . implode(',', [$model::USE_ACTIVE, $model::USE_INACTIVE])],
				'use_js' => ['required', 'int', 'in:' . implode(',', [$model::USE_ACTIVE, $model::USE_INACTIVE])],
			]);

			$this->update->text('title', 'Editing aliases');
			$this->update->text('responseErrorNotFound', 'Aliases not found');
			$this->update->text('responseOk', 'The alias has been changed');
		}

		private function initDelete(): void {
			$this->delete = new Delete($this);

			$this->delete->text('responseOk', 'Alias removed');
		}

		private function getContexts(): array {
			/** @var Models\Locales\Contexts $contextModel */ $contextModel = model('locales.contexts', \Base\Models::SOURCE_EDITORS);

			$response = $contextModel->index('id', 'name');
			$out = [];
			foreach ($response() as $item) {
				$out[$item['id']] = $item['name'];
			}

			return $out;
		}

		/**
		 * Prepare data for view
		 * @param array $item - Data
		 * @return void
		 */
		private function prepareView(array & $item): void {
			/** @var Models\Locales\Aliases $model */ $model = $this->model();

			$item['use_php'] = $model::USE_ACTIVE;
			$item['use_js'] = $model::USE_ACTIVE;
		}

	}
