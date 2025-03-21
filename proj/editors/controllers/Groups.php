<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers;

	use Base\Editor\Controller;
	use Base\Helper\Accumulator;
	use proj\editors\models\Groups as Model;

	/**
	 * Контроллер-редактор групп
	 * @controller
	 */
	class Groups extends Controller {
		public function __construct() {
			parent::__construct(app()->features('groups'), 'groups');

			$this->titleSelect = 'Список групп';
			$this->titleBrowse = 'Просмотр группы';
			$this->titleCreate = 'Добавление группы';
			$this->titleUpdate = 'Изменение группы';

			$this->textDeleteConfirm = 'Удалить группу?';

			$this->textResponseOkCreate = 'Группа добавлена';
			$this->textResponseOkUpdate = 'Группа изменена';
			$this->textResponseOkDelete = 'Группа удалена';

			$this->textBtnCreate = 'Добавить';
			$this->textBtnUpdate = 'Изменить';

			/** @var Model $groups */ $groups = $this->model();

//			$this->names = [
//				'name' => __('Наименование'),
//				'state' => __('Состояние'),
//			];

			$this->validateDataCreate = [
				'name' => ['required', 'trim', 'string'],
			];

//			$this->validateDataUpdate = [
//				'name' => ['required', 'trim', 'string'],
//				'state' => ['required', 'int', 'in:' . implode(',', [$groups::STATE_ACTIVE, $groups::STATE_INACTIVE])],
//			];
		}

		/**
		 * Задаёт поля для выборки
		 * @return void
		 */
		protected function setFieldsSelect(): void {
			/** @var Model $groups */ $groups = $this->model();

			$this->fieldsSelect->browse->text('id', '#');
			$this->fieldsSelect->browse->fromArray('state', __('Состояние'), $groups->getStates());
			$this->fieldsSelect->browse->text('name', __('Наименование'));
		}

		/**
		 * Задаёт поля для просмотра
		 * @return void
		 */
		protected function setFieldsBrowse(): void {
			/** @var Model $model */ $model = $this->getModel();

			$this->fieldsBrowse->browse->fromArray('state', __('Состояние'), $model->getStates());

			$this->fieldsBrowse->browse->text('name', __('Наименование'));
		}

		/**
		 * Задаёт поля для создания
		 * @return void
		 */
		protected function setFieldsCreate(): void {
			$this->fieldsCreate->edit->text('name', __('Наименование'));
		}

		/**
		 * Задаёт поля для редактирования
		 * @return void
		 */
		protected function setFieldsUpdate(): void {
			/** @var Model $model */ $model = $this->getModel();

			$this->fieldsUpdate->edit->hidden('id');

			$this->fieldsUpdate->edit->text('name', __('Наименование'));

			$this->fieldsUpdate->edit->select('state', __('Состояние'), [
				$model::STATE_ACTIVE => __('Активная'),
				$model::STATE_INACTIVE => __('Не активная'),
			]);
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$id = isset($item['id']) ? (int)$item['id'] : 0;

			$links->push($this->update->linkHrefID($id, $this->textDoUpdate, $item));
			//function (array $item) { return Units\Users::instance()->editor_access_users->update->GetLinkHrefAllow(Units\Users::instance()->editor_access_users::ACCESS_UPDATE, 'Установить права', array_merge(['uid' => $item['id']], $this->params)); },
			$links->push($this->do_delete->linkHrefID($id, $this->textDoDelete, $item));

			return $links;
		}

	}