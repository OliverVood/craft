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
	use Proj\Editors\Models;

	/**
	 * Контроллер-редактор пользователей
	 * @controller
	 */
	class Users extends Controller {
		public function __construct() {
			parent::__construct(app()->features('users'), 'users');

			/** @var Models\Users $model */ $model = $this->model();
			/** @var Models\Groups $groupsModel */ $groupsModel = model('groups', \Base\Models::SOURCE_EDITORS);

			$response = $groupsModel->index('id', 'name');
			$groups = [];
			foreach ($response() as $group) {
				$groups[$group['id']] = $group['name'];
			}

			$this->names = [
				'login' => __('Логин'),
				'first_name' => __('Имя'),
				'last_name' => __('Фамилия'),
				'father_name' => __('Отчество'),
				'password' => __('Пароль'),
				'password_confirm' => __('Повторение пароля'),
				'gid' => __('Группа'),
				'state' => __('Состояние'),
			];

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->select->fields()->browse->text('group', __('Группа'));
			$this->select->fields()->browse->text('login', __('Логин'));
			$this->select->fields()->browse->text('last_name', __('Фамилия'));
			$this->select->fields()->browse->text('first_name', __('Имя'));
			$this->select->fields()->browse->text('father_name', __('Отчество'));
			$this->select->text('title', 'Список пользователей');

			$this->browse = new Browse($this);
			$this->browse->text('title', 'Просмотр пользователя');
			$this->browse->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->browse->fields()->browse->text('group', __('Группа'));
			$this->browse->fields()->browse->text('login', __('Логин'));
			$this->browse->fields()->browse->text('last_name', __('Фамилия'));
			$this->browse->fields()->browse->text('first_name', __('Имя'));
			$this->browse->fields()->browse->text('father_name', __('Отчество'));

			$this->create = new Create($this);
			$this->create->fields()->edit->select('gid', __('Группа'), $groups, ['empty' => ['key' => 0, 'value' => __('Выберите')]]);
			$this->create->fields()->edit->text('login', __('Логин'));
			$this->create->fields()->edit->text('last_name', __('Фамилия'));
			$this->create->fields()->edit->text('first_name', __('Имя'));
			$this->create->fields()->edit->text('father_name', __('Отчество'));
			$this->create->fields()->edit->password('password', __('Пароль'));
			$this->create->fields()->edit->password('password_confirm', __('Повторение пароля'));
			$this->create->validate([
				'gid' => ['required', 'int', 'foreign:craft,groups,id'],
				'login' => ['required', 'trim', 'string'],
				'last_name' => ['trim', 'string'],
				'first_name' => ['trim', 'string'],
				'father_name' => ['trim', 'string'],
				'password' => ['required', 'string', 'min:6', 'max:32', 'contains:number,letter,lowercase,uppercase,special', 'encryption'],
				'password_confirm' => ['string', 'same:password', 'unset'],
			]);
			$this->create->text('title', 'Добавление пользователя');
			$this->create->text('btn', 'Добавить');
			$this->create->text('responseOk', 'Пользователь добавлен');

			$this->update = new Update($this);
			$this->update->fnPrepareView = fn (int $id, array & $item) => $this->prepareViewUpdate($id, $item);
			$this->update->fields()->edit->hidden('id');
			$this->update->fields()->edit->select('gid', __('Группа'), $groups, ['empty' => ['key' => 0, 'value' => __('Выберите')]]);
			$this->update->fields()->edit->text('login', __('Логин'));
			$this->update->fields()->edit->text('last_name', __('Фамилия'));
			$this->update->fields()->edit->text('first_name', __('Имя'));
			$this->update->fields()->edit->text('father_name', __('Отчество'));
			$this->update->fields()->edit->password('password', __('Пароль'));
			$this->update->fields()->edit->password('password_confirm', __('Повторение пароля'));
			$this->update->fields()->edit->select('state', __('Состояние'), [
				$model::STATE_ACTIVE => __('Активный'),
				$model::STATE_INACTIVE => __('Не активный'),
				$model::STATE_BLOCK => __('Заблокированный'),
			]);
			$this->update->validate([
				'gid' => ['required', 'int', 'foreign:craft,groups,id'],
				'login' => ['required', 'trim', 'string'],
				'last_name' => ['trim', 'string'],
				'first_name' => ['trim', 'string'],
				'father_name' => ['trim', 'string'],
				'password' => ['string', 'min:6', 'max:32', 'contains:number,letter,lowercase,uppercase,special', 'encryption', 'unset_if_empty'],
				'password_confirm' => ['same:password', 'unset'],
				'state' => ['required', 'int', 'in:' . implode(',', [$model::STATE_ACTIVE, $model::STATE_INACTIVE, $model::STATE_BLOCK])],
			]);
			$this->update->text('title', 'Изменение пользователя');
			$this->update->text('btn', 'Изменить');
			$this->update->text('responseOk', 'Пользователь изменён');

			$this->delete = new Delete($this);
			$this->delete->text('confirm', 'Удалить пользователя?');
			$this->delete->text('responseOk', 'Пользователь удалён');
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

		/**
		 * Подготовка данных для блока обновления
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareViewUpdate(int $id, array & $item): void {
			$item['password'] = '';
		}

	}