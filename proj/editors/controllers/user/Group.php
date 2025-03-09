<?php

	namespace Proj\Editors\Controllers\User;

	use Base\Editor\Controller;
	use Base\Helper\Accumulator;
	use Base\Route as BaseRoute;
	use Proj\Editors\Consts\Collections;
	use Proj\Editors\Models\User\Group as Model;

	class Group extends Controller {
		public function __construct() {
			parent::__construct(Collections\GROUP['id'], Collections\GROUP['name'], __('Группы'), 'user.group', 'user.group');

			/** @var Model $model */ $model = $this->getModel();

			$this->names = [
				'name' => __('Наименование'),

				'state' => __('Состояние'),
			];

			$this->validateDataCreate = [
				'name' => ['required', 'trim', 'string'],
			];

			$this->validateDataUpdate = [
				'name' => ['required', 'trim', 'string'],
				'state' => ['required', 'int', 'in:' . implode(',', [$model::STATE_ACTIVE, $model::STATE_INACTIVE])],
			];
		}

		/**
		 * Устанавливает текста для редактора
		 * @return void
		 */
		protected function regTexts(): void {
			parent::regTexts();

			$this->titleSelect = __('Список групп');
			$this->titleBrowse = __('Просмотр группы');
			$this->titleCreate = __('Добавление группы');
			$this->titleUpdate = __('Изменение группы');

			$this->textDeleteConfirm = __('Удалить группу?');

			$this->textResponseOkCreate = __('Группа добавлена');
			$this->textResponseOkUpdate = __('Группа изменена');
			$this->textResponseOkDelete = __('Группа удалена');

			$this->textBtnCreate = __('Добавить');
			$this->textBtnUpdate = __('Изменить');
		}

		/**
		 * Регистрация маршрутов
		 * @return void
		 */
		protected function regRoutes(): void {
			if (POINTER != 'xhr') return;

			BaseRoute::set("{$this->name}::select", "{$this->pathController}::select", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::browse", "{$this->pathController}::browse", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::create", "{$this->pathController}::create", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::update", "{$this->pathController}::update", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::delete", "{$this->pathController}::delete", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_create", "{$this->pathController}::doCreate", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_update", "{$this->pathController}::doUpdate", BaseRoute::SOURCE_EDITORS);
			BaseRoute::set("{$this->name}::do_delete", "{$this->pathController}::doDelete", BaseRoute::SOURCE_EDITORS);
		}

		/**
		 * Регистрирует коллекцию и права
		 * @return void
		 */
		protected function regActions(): void {
			$this->addCollection();

			$this->addRight(self::ACCESS_SETTING, 'setting', __('Назначение прав'));
			$this->addRight(self::ACCESS_SELECT, 'select', __('Выборка'));
			$this->addRight(self::ACCESS_BROWSE, 'browse', __('Вывод'));
			$this->addRight(self::ACCESS_CREATE, 'create', __('Создание'));
			$this->addRight(self::ACCESS_UPDATE, 'update', __('Изменение'));
			$this->addRight(self::ACCESS_DELETE, 'delete', __('Удаление'));
		}

		/**
		 * Задаёт поля для выборки
		 * @return void
		 */
		protected function setFieldsSelect(): void {
			/** @var Model $model */ $model = $this->getModel();

			$this->fieldsSelect->browse->text('id', '#');

			$this->fieldsSelect->browse->fromArray('state', __('Состояние'), $model->getStates());

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

			$links->push($this->update->linkHrefID($item['id'] ?? 0, $this->textDoUpdate, $item));
			//function (array $item) { return Units\Users::instance()->editor_access_users->update->GetLinkHrefAllow(Units\Users::instance()->editor_access_users::ACCESS_UPDATE, 'Установить права', array_merge(['uid' => $item['id']], $this->params)); },
			$links->push($this->do_delete->linkHrefID($item['id'] ?? 0, $this->textDoDelete, $item));

			return $links;
		}

	}