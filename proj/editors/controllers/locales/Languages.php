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
	class Languages extends Controller {
		public function __construct() {
			parent::__construct(feature('languages'), 'locales.languages');

			$this->names = [
				'code' => __('Code'),
				'state' => __('Status'),
			];

			/** @var Models\Locales\Languages $model */ $model = $this->model();

			$this->initSelect();
			$this->initBrowse($model);
			$this->initCreate();
			$this->initUpdate($model);
			$this->initDelete();
		}

		private function initSelect(): void {
			$this->select = new Select($this);
			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->text('code', $this->names['code']);

			$this->select->text('title', 'Список языков');
		}

		private function initBrowse(Models\Locales\Languages $model): void {
			$this->browse = new Browse($this);

			$this->browse->fields()->browse->text('code', $this->names['code']);
			$this->browse->fields()->browse->fromArray('state', $this->names['state'], $model->getStates());
			$this->browse->fields()->browse->text('code', $this->names['code']);

			$this->browse->text('title', 'Browse language');
			$this->browse->text('responseErrorNotFound', 'Language not found');
		}

		private function initCreate(): void {
			$this->create = new Create($this);

			$this->create->fields()->edit->text('code', $this->names['code']);

			$this->create->validate([
				'code' => ['required', 'trim', 'string', 'len:2', 'unique:craft,locales_languages,code'],
			]);

			$this->create->text('title', 'Добавление языка');
			$this->create->text('btn', 'Добавить');
			$this->create->text('responseErrorValidate', 'Ошибка валидации данных');
			$this->create->text('responseOk', 'Язык добавлен');
		}

		private function initUpdate(Models\Locales\Languages $model): void {
			$this->update = new Update($this);

			$this->update->fields()->edit->text('code', $this->names['code']);
			$this->update->fields()->edit->select('state', $this->names['state'], [
				$model::STATE_ACTIVE => __('Активный'),
				$model::STATE_INACTIVE => __('Не активный'),
			]);

			$this->update->validate([
				'code' => ['required', 'trim', 'string', 'len:2', 'unique:craft,locales_languages,code'],
				'state' => ['required', 'int', 'in:' . implode(',', [$model::STATE_ACTIVE, $model::STATE_INACTIVE])],
			]);

			$this->update->text('title', 'Редактирование языка');
			$this->update->text('btn', 'Изменить');
			$this->update->text('responseOk', 'Язык изменён');
		}

		private function initDelete(): void {
			$this->delete = new Delete($this);

			$this->delete->text('responseOk', __('Язык удалён'));
		}

	}
