<?php

	namespace Proj\Editors\Controllers\User;

	use Base\Editor\Controller;
	use Base\Helper\Accumulator;
	use Base\Route as BaseRoute;
	use Proj\Editors\Consts\Collections;
	use Proj\Editors\Models\User\User as Model;

	class User extends Controller {
		public function __construct() {
			parent::__construct(Collections\USER['id'], Collections\USER['name'], __('Пользователи'), 'user.user', 'user.user');

			/** @var Model $model */ $model = $this->getModel();

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
		 * Устанавливает текста для редактора
		 * @return void
		 */
		protected function regTexts(): void {
			parent::regTexts();

			$this->titleSelect = __('Список пользователей');
			$this->titleBrowse = __('Просмотр пользователя');
			$this->titleCreate = __('Добавление пользователя');
			$this->titleUpdate = __('Изменение пользователя');

			$this->textDeleteConfirm = __('Удалить пользователя?');

			$this->textResponseOkCreate = __('Пользователь добавлен');
			$this->textResponseOkUpdate = __('Пользователь изменён');
			$this->textResponseOkDelete = __('Пользователь удалён');

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

			$this->fieldsSelect->browse->text('group', __('Группа'));

			$this->fieldsSelect->browse->text('login', __('Логин'));
			$this->fieldsSelect->browse->text('last_name', __('Фамилия'));
			$this->fieldsSelect->browse->text('first_name', __('Имя'));
			$this->fieldsSelect->browse->text('father_name', __('Отчество'));
		}

		/**
		 * Задаёт поля для просмотра
		 * @return void
		 */
		protected function setFieldsBrowse(): void {
			/** @var Model $model */ $model = $this->getModel();

			$this->fieldsBrowse->browse->fromArray('state', __('Состояние'), $model->getStates());

			$this->fieldsBrowse->browse->text('group', __('Группа'));

			$this->fieldsBrowse->browse->text('login', __('Логин'));
			$this->fieldsBrowse->browse->text('last_name', __('Фамилия'));
			$this->fieldsBrowse->browse->text('first_name', __('Имя'));
			$this->fieldsBrowse->browse->text('father_name', __('Отчество'));
		}

		/**
		 * Задаёт поля для создания
		 * @return void
		 */
		protected function setFieldsCreate(): void {
			/** @var \Proj\Editors\Models\User\Group $groupsModel */ $groupsModel = modelEditor('user.group');

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
			/** @var Model $model */ $model = $this->getModel();
			/** @var \Proj\Editors\Models\User\Group $groupsModel */ $groupsModel = modelEditor('user.group');

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
			/** @var \Proj\Editors\Models\User\Group $groupsModel */ $groupsModel = modelEditor('user.group');

			$validated = parent::validationDataCreate($data, $errors);

			if (!$groupsModel->browse($data['gid'], ['id'])) {
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
			/** @var \Proj\Editors\Models\User\Group $groupsModel */ $groupsModel = modelEditor('user.group');

			$validated = parent::validationDataUpdate($data, $errors);

			if (!$groupsModel->browse($data['gid'], ['id'])) {
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

			$links->push($this->update->linkHrefID($item['id'] ?? 0, $this->textDoUpdate, $item));
			$links->push($this->do_delete->linkHrefID($item['id'] ?? 0, $this->textDoDelete, $item));

			return $links;
		}

	}