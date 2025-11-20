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
			parent::__construct(feature('groups'), 'groups');

			$this->names = [
				'name' => __('Наименование'),
				'state' => __('Состояние'),
			];

			/** @var Model $model */ $model = $this->model();

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->fromArray('state', $this->names['state'], $model->getStates());
			$this->select->fields()->browse->text('name', $this->names['name']);
			$this->select->text('title', 'Список групп');

			$this->browse = new Browse($this);
			$this->browse->fields()->browse->fromArray('state', $this->names['state'], $model->getStates());
			$this->browse->fields()->browse->text('name', $this->names['name']);
			$this->browse->text('title', 'Просмотр группы');

			$this->create = new Create($this);
			$this->create->fields()->edit->text('name', $this->names['name']);
			$this->create->validate([
				'name' => ['required', 'trim', 'string'],
			]);
			$this->create->text('title', 'Добавление группы');
			$this->create->text('btn', 'Добавить');
			$this->create->text('responseOk', 'Группа добавлена');

			$this->update = new Update($this);
			$this->update->fields()->edit->text('name', $this->names['name']);
			$this->update->fields()->edit->select('state', $this->names['state'], [
				$model::STATE_ACTIVE => __('Активная'),
				$model::STATE_INACTIVE => __('Не активная'),
			]);
			$this->update->validate([
				'name' => ['required', 'trim', 'string'],
				'state' => ['required', 'int', 'in:' . implode(',', [$model::STATE_ACTIVE, $model::STATE_INACTIVE])],
			]);
			$this->update->text('title', 'Изменение группы');
			$this->update->text('responseOk', 'Группа изменена');

			$this->delete = new Delete($this);
			$this->delete->text('confirm', 'Удалить группу?');
			$this->delete->text('responseOk', 'Группа удалена');
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		private function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$id = isset($item['id']) ? (int)$item['id'] : 0;

			$links->push($this->linkUpdate->linkHrefID($id, $this->update->__('do'), $item));
			$links->push($this->linkAccess->linkHrefID($id, __('Установить права доступа'), ['id' => $id]));
			$links->push($this->linkDoDelete->linkHrefID($id, $this->delete->__('do'), $item));

			return $links;
		}

	}