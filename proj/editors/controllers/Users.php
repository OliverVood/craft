<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers;

	use Base\Editor\Actions\Browse;
	use Base\Editor\Actions\Select;
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

			$this->actionSelect = new Select($this);
			$this->actionSelect->text('title', 'Список пользователей');
			$this->actionSelect->fields()->browse->text('id', '#');
			$this->actionSelect->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->actionSelect->fields()->browse->text('group', __('Группа'));
			$this->actionSelect->fields()->browse->text('login', __('Логин'));
			$this->actionSelect->fields()->browse->text('last_name', __('Фамилия'));
			$this->actionSelect->fields()->browse->text('first_name', __('Имя'));
			$this->actionSelect->fields()->browse->text('father_name', __('Отчество'));

			$this->actionBrowse = new Browse($this);
			$this->actionBrowse->text('title', 'Просмотр пользователя');
			$this->actionBrowse->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->actionBrowse->fields()->browse->text('group', __('Группа'));
			$this->actionBrowse->fields()->browse->text('login', __('Логин'));
			$this->actionBrowse->fields()->browse->text('last_name', __('Фамилия'));
			$this->actionBrowse->fields()->browse->text('first_name', __('Имя'));
			$this->actionBrowse->fields()->browse->text('father_name', __('Отчество'));

			$this->titleCreate = 'Добавление пользователя';
			$this->titleUpdate = 'Изменение пользователя';

			$this->textDeleteConfirm = 'Удалить пользователя?';

			$this->textResponseOkCreate = 'Пользователь добавлен';
			$this->textResponseOkUpdate = 'Пользователь изменён';
			$this->textResponseOkDelete = 'Пользователь удалён';

			$this->textBtnCreate = 'Добавить';
			$this->textBtnUpdate = 'Изменить';

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

			$this->validateDataCreate = [
				'gid' => ['required', 'int'],
				'login' => ['required', 'trim', 'string'],
				'last_name' => ['trim', 'string'],
				'first_name' => ['trim', 'string'],
				'father_name' => ['trim', 'string'],
				'password' => ['required', 'string', 'min:6', 'max:32', 'contains:number,letter,lowercase,uppercase,special', 'encryption'],
				'password_confirm' => ['string', 'same:password', 'unset'],
			];

			$this->validateDataUpdate = [
				'gid' => ['required', 'int'],
				'login' => ['required', 'trim', 'string'],
				'last_name' => ['trim', 'string'],
				'first_name' => ['trim', 'string'],
				'father_name' => ['trim', 'string'],
				'password' => ['string', 'min:6', 'max:32', 'contains:number,letter,lowercase,uppercase,special', 'encryption', 'unset_if_empty'],
				'password_confirm' => ['same:password', 'unset'],
				'state' => ['required', 'int', 'in:' . implode(',', [$model::STATE_ACTIVE, $model::STATE_INACTIVE, $model::STATE_BLOCK])],
			];
		}

		/**
		 * Задаёт поля для создания
		 * @return void
		 */
		protected function setFieldsCreate(): void {
			/** @var Models\Groups $groupsModel */ $groupsModel = model('groups', \Base\Models::SOURCE_EDITORS);

			$response = $groupsModel->index('id', 'name');
			$groups = [];
			foreach ($response() as $group) {
				$groups[$group['id']] = $group['name'];
			}

			$this->fieldsCreate->edit->select('gid', __('Группа'), $groups, ['empty' => ['key' => 0, 'value' => __('Выберите')]]);
			$this->fieldsCreate->edit->text('login', __('Логин'));
			$this->fieldsCreate->edit->text('last_name', __('Фамилия'));
			$this->fieldsCreate->edit->text('first_name', __('Имя'));
			$this->fieldsCreate->edit->text('father_name', __('Отчество'));
			$this->fieldsCreate->edit->password('password', __('Пароль'));
			$this->fieldsCreate->edit->password('password_confirm', __('Повторение пароля'));
		}

		/**
		 * Задаёт поля для редактирования
		 * @return void
		 */
		protected function setFieldsUpdate(): void {
			/** @var Models\Users $model */ $model = $this->model();
			/** @var Models\Groups $groupsModel */ $groupsModel = model('groups', \Base\Models::SOURCE_EDITORS);

			$response = $groupsModel->index('id', 'name');
			$groups = [];
			foreach ($response() as $group) {
				$groups[$group['id']] = $group['name'];
			}

			$this->fieldsUpdate->edit->hidden('id');
			$this->fieldsUpdate->edit->select('gid', __('Группа'), $groups, ['empty' => ['key' => 0, 'value' => __('Выберите')]]);
			$this->fieldsUpdate->edit->text('login', __('Логин'));
			$this->fieldsUpdate->edit->text('last_name', __('Фамилия'));
			$this->fieldsUpdate->edit->text('first_name', __('Имя'));
			$this->fieldsUpdate->edit->text('father_name', __('Отчество'));
			$this->fieldsUpdate->edit->password('password', __('Пароль'));
			$this->fieldsUpdate->edit->password('password_confirm', __('Повторение пароля'));
			$this->fieldsUpdate->edit->select('state', __('Состояние'), [
				$model::STATE_ACTIVE => __('Активный'),
				$model::STATE_INACTIVE => __('Не активный'),
				$model::STATE_BLOCK => __('Заблокированный'),
			]);
		}

		/**
		 * Подготовка данных для блока обновления
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		protected function prepareViewUpdate(int $id, array & $item): void {
			$item['password'] = '';
		}

		/**
		 * Проверяет данные для создания
		 * @param array $data - Данные
		 * @param array $errors - Ошибки
		 * @return array|null
		 */
		protected function validationDataCreate(array $data, array & $errors): ?array {
			/** @var Models\Groups $groupsModel */ $groupsModel = model('groups', \Base\Models::SOURCE_EDITORS);

			$validated = parent::validationDataCreate($data, $errors);

			if (!$groupsModel->browse((int)$data['gid'], ['id'])) {
				$validated = null;
				$errors['gid'][] = __('Группа не найдена');
			}

			return $validated;
		}

		/**
		 * Проверяет данные для изменения
		 * @param array $data - Данные
		 * @param array $errors - Ошибки
		 * @return array|null
		 */
		protected function validationDataUpdate(array $data, array & $errors): ?array {
			/** @var Models\Groups $groupsModel */ $groupsModel = model('groups', \Base\Models::SOURCE_EDITORS);

			$validated = parent::validationDataUpdate($data, $errors);

			if (!$groupsModel->browse((int)$data['gid'], ['id'])) {
				$validated = null;
				$errors['gid'][] = __('Группа не найдена');
			}

			return $validated;
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