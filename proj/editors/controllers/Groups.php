<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers;

	use Base\Editor\Actions\Browse;
	use Base\Editor\Actions\Create;
	use Base\Editor\Actions\Delete;
	use Base\Editor\Actions\Select;
	use Base\Editor\Actions\Update;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;
	use Proj\Editors\Models\Groups as Model;

	/**
	 * Контроллер-редактор групп
	 * @controller
	 */
	class Groups extends Controller {
		public function __construct() {
			parent::__construct(app()->features('groups'), 'groups');

			/** @var Model $model */ $model = $this->model();

			$this->names = [
				'name' => __('Наименование'),
				'state' => __('Состояние'),
			];

			$this->actionSelect = new Select($this);
			$this->actionSelect->fields()->browse->text('id', '#');
			$this->actionSelect->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->actionSelect->fields()->browse->text('name', __('Наименование'));
			$this->actionSelect->text('title', 'Список групп');

			$this->actionBrowse = new Browse($this);
			$this->actionBrowse->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->actionBrowse->fields()->browse->text('name', __('Наименование'));
			$this->actionBrowse->text('title', 'Просмотр группы');

			$this->actionCreate = new Create($this);
			$this->actionCreate->fields()->edit->text('name', __('Наименование'));
			$this->actionCreate->validate([
				'name' => ['required', 'trim', 'string'],
			]);
			$this->actionCreate->text('title', 'Добавление группы');
			$this->actionCreate->text('btn', 'Добавить');
			$this->actionCreate->text('responseOk', 'Группа добавлена');

			$this->actionUpdate = new Update($this);
			$this->actionUpdate->fields()->edit->hidden('id');
			$this->actionUpdate->fields()->edit->text('name', __('Наименование'));
			$this->actionUpdate->fields()->edit->select('state', __('Состояние'), [
				$model::STATE_ACTIVE => __('Активная'),
				$model::STATE_INACTIVE => __('Не активная'),
			]);
			$this->actionUpdate->validate([
				'name' => ['required', 'trim', 'string'],
				'state' => ['required', 'int', 'in:' . implode(',', [$model::STATE_ACTIVE, $model::STATE_INACTIVE])],
			]);
			$this->actionUpdate->text('title', 'Изменение группы');
			$this->actionUpdate->text('responseOk', 'Группа изменена');

			$this->actionDelete = new Delete($this);
			$this->actionDelete->text('confirm', 'Удалить группу?');
			$this->actionDelete->text('responseOk', 'Группа удалена');
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$id = isset($item['id']) ? (int)$item['id'] : 0;

			$links->push($this->update->linkHrefID($id, __($this->textDoUpdate), $item));
			$links->push($this->access->linkHrefID($id, __($this->textDoAccess), ['id' => $id]));
			$links->push($this->do_delete->linkHrefID($id, __($this->textDoDelete), $item));

			return $links;
		}

	}