<?php

	namespace Base\Editor;

	use Base\Access\Feature;
	use Base\ControllerAccess;
	use Base\Data\Set;
	use Base\Helper\Accumulator;
	use Base\Helper\Pagination;
	use Base\Helper\Response;
	use Base\Models;
	use Base\UI\View;
	use JetBrains\PhpStorm\NoReturn;

	require DIR_BASE_EDITOR . 'Access.php';
	require DIR_BASE_EDITOR . 'Link.php';
	require DIR_BASE_EDITOR . 'Route.php';
	require DIR_BASE_EDITOR . 'Texts.php';
	require DIR_BASE_EDITOR . 'Fields.php';

	/**
	 * Базовый класс для работы с контроллерами-редакторами
	 * @controller
	 */
	abstract class Controller extends ControllerAccess {
		use Access;
		use Link;
		use Route;
		use Texts;

		protected int $id;
		protected string $name;
		protected string $title;

		protected string $pathController;
		protected string $modelName;

		protected string $tplSelect = 'admin.editor.select';
		protected string $tplBrowse = 'admin.editor.browse';
		protected string $tplCreate = 'admin.editor.create';
		protected string $tplUpdate = 'admin.editor.update';

		protected array $names = [];

		protected Fields $fieldsSelect;
		protected Fields $fieldsBrowse;
		protected Fields $fieldsCreate;
		protected Fields $fieldsUpdate;

		protected int $page_entries = 10;

		protected array $validateDataCreate = [];
		protected array $validateDataUpdate = [];

		public function __construct(Feature $feature, string $modelName/*int $id, string $name, string $title, ?string $pathController = null, ?string $pathModel = null*/) {
			parent::__construct($feature);

//			$this->id = $id;
//			$this->name = $name;
//			$this->title = $title;

//			$this->pathController = $pathController ?? $name;
			$this->modelName = $modelName;
//
//			$this->regTexts();
//			$this->regActions();
			$this->links();
//			$this->regRoutes();

			$this->fieldsSelect = new Fields();
//			$this->fieldsBrowse = new Fields();
			$this->fieldsCreate = new Fields();
//			$this->fieldsUpdate = new Fields();
		}

		/**
		 * Блок выборки данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param int $redirectPage - Текущая страница для перенаправления
		 * @return void
		 */
		#[NoReturn] public function select(Set $data, int $redirectPage = 0): void {
			if (!$this->allowSelect()) response()->forbidden(__($this->textResponseErrorAccess));

			$page = $redirectPage ?: $data->defined('page')->int(1);

			/** @var Model $ips */ $ips = $this->model();

			[$items, $ext] = $ips->select(['*'], $page, $this->page_entries);

			$this->prepareViewSelect($items);

			$this->setFieldsSelect();

			$title = $this->titleSelect;
			$fields = $this->fieldsSelect;
			$pagination = $this->page_entries ? new Pagination($this->select, $ext['page']['current'], $ext['page']['count']) : null;
			$editor = $this;

			response()->history($this->select, ['page' => $page]);
			response()->section('content', view($this->tplSelect, compact('title', 'fields', 'items' ,'pagination', 'editor')));
			response()->ok();
		}

		/**
		 * Блок просмотра данных
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @param int $redirectID - Идентификатор для перенаправления
		 * @return void
		 */
		public function browse(Input $input, int $redirectID = 0): void {
			$id = $redirectID ?: $input->defined('id')->int(0);

			if ($id < 1) Response::SendNoticeError($this->textResponseErrorNotFound);

			if (!$this->allowBrowse($id)) Response::SendNoticeError($this->textResponseErrorAccess);

			$item = $this->getModel()->browse($id, ['*']);

			$this->prepareViewBrowse($id, $item);

			$this->setFieldsBrowse();

			if (!$item) Response::SendNoticeError($this->textResponseErrorNotFound);

			$title = "{$this->titleBrowse} #{$id}";
			$fields = $this->fieldsBrowse;
			$editor = $this;

			Response::pushHistory($this->browse, ['id' => $id]);
			Response::pushSection('content', View::get($this->tplBrowse, compact('title', 'fields', 'id', 'item', 'editor')));
			Response::SendJSON();
		}

		/**
		 * Блок создания данных
		 * @controllerMethod
		 * @return void
		 */
		public function create(): void {
			if (!$this->allowCreate()) response()->forbidden($this->textResponseErrorAccess);

			$this->prepareViewCreate();

			$this->setFieldsCreate();

			$title = $this->titleCreate;
			$fields = $this->fieldsCreate;
			$action = $this->do_create;
			$textBtn = $this->textBtnCreate;
			$editor = $this;

			response()->history($this->create);
			response()->section('content', view($this->tplCreate, compact('title', 'fields', 'action', 'textBtn', 'editor')));
			response()->ok();
		}

		/**
		 * Блок обновления данных
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @return void
		 */
		public function update(Input $input): void {
			$id = $input->defined('id')->int(0);

			if ($id < 1) Response::SendNoticeError($this->textResponseErrorNotFound);

			if (!$this->allowUpdate($id)) Response::SendNoticeError($this->textResponseErrorAccess);

			$item = $this->getModel()->browse($id, ['*']);

			$this->prepareViewUpdate($id, $item);

			$this->setFieldsUpdate();

			$title = "{$this->titleUpdate} #{$id}";
			$fields = $this->fieldsUpdate;
			$action = $this->do_update;
			$textBtn = $this->textBtnUpdate;
			$editor = $this;

			Response::pushHistory($this->update, ['id' => $id]);
			Response::pushSection('content', View::get($this->tplUpdate, compact('title', 'fields', 'id', 'item', 'action', 'textBtn', 'editor')));
			Response::SendJSON();
		}

		/**
		 * Создание
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		public function doCreate(Set $data): void {
			if (!$this->allowCreate()) response()->forbidden($this->textResponseErrorAccess);

			$data = $data->defined()->all();
			$this->prepareCreate($data);
			$errors = [];
			$validated = validation($data, $this->validateDataCreate, $this->names, $errors);

			if ($errors) response()->unprocessableEntity(__($this->textResponseErrorValidate), $errors);
dd(134);
//			if (!$id = $this->getModel()->create($validated)) Response::sendNoticeError($this->textResponseErrorCreate);
//
//			Response::pushNoticeOk($this->textResponseOkCreate);
//			$this->browse($data, $id);
		}

		/**
		 * Обновление
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @return void
		 */
		public function doUpdate(Input $input): void {
			$id = $input->defined('id')->int(0);

			if ($id < 1) Response::SendNoticeError($this->textResponseErrorNotFound);

			if (!$this->allowUpdate($id)) Response::SendNoticeError($this->textResponseErrorAccess);

			$data = $input->defined()->all();

			$this->prepareUpdate($data, $id);
			$errors = [];
			$validated = $this->validationDataUpdate($data, $errors);

			if ($validated === null) {
				Response::pushNoticeError($this->textResponseErrorValidate);
				Response::pushErrors($errors);
				Response::sendJSON();
			}

			if (!$this->getModel()->update($validated, $id)) Response::sendNoticeError($this->textResponseErrorUpdate);

			Response::pushNoticeOk($this->textResponseOkUpdate);
			$this->browse($input, $id);
		}

		/**
		 * Удаление
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @return void
		 */
		public function doDelete(Input $input): void {
			$id = $input->defined('id')->int(0);

			if ($id < 1) Response::SendNoticeError($this->textResponseErrorNotFound);

			if (!$this->allowDelete($id)) Response::SendNoticeError($this->textResponseErrorAccess);

			$this->prepareDelete($id);

			if (!$this->getModel()->delete($id)) Response::sendNoticeError($this->textResponseErrorDelete);

			Response::pushNoticeOk($this->textResponseOkDelete);
			$this->select($input, $input->old('page')->int(1));
		}

		/**
		 * Изменение состояния
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @return void
		 */
		public function setState(Input $input): void {
			$id = $input->defined('id')->int(0);
			$state = $input->defined('state')->int(0);

			if ($id < 1) Response::SendNoticeError($this->textResponseErrorNotFound);
			if ($state < 1) Response::SendNoticeError($this->textResponseErrorState);

			if (!$this->allowState($id)) Response::SendNoticeError($this->textResponseErrorAccess);

			$this->prepareSetState($id, $state);

			if (!$this->getModel()->setState($id, $state)) Response::sendNoticeError($this->textResponseErrorState);

			Response::pushNoticeOk($this->textResponseOkSetState);
			$this->select($input, $input->old('page')->int(1));
		}

		/**
		 * Подготовка данных для блока выборки
		 * @param \Base\DB\Response $items
		 * @return void
		 */
		protected function prepareViewSelect(\Base\DB\Response & $items): void {  }

		/**
		 * Подготовка данных для блока просмотра
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		protected function prepareViewBrowse(int $id, array & $item): void {  }

		/**
		 * Подготовка данных для блока создания
		 * @return void
		 */
		protected function prepareViewCreate(): void {  }

		/**
		 * Подготовка данных для блока обновления
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		protected function prepareViewUpdate(int $id, array & $item): void {  }

		/**
		 * Подготовка данных перед созданием
		 * @param array $data - Данные
		 * @return void
		 */
		protected function prepareCreate(array & $data): void {  }

		/**
		 * Подготовка данных перед изменением
		 * @param array $data - Данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		protected function prepareUpdate(array & $data, int $id): void {  }

		/**
		 * Подготовка данных перед удалением
		 * @param int $id - Идентификатор
		 * @return void
		 */
		protected function prepareDelete(int $id): void {  }

		/**
		 * Подготовка данных перед изменением состояния
		 * @param int $id - Идентификатор
		 * @param int $state - Состояние
		 * @return void
		 */
		protected function prepareSetState(int $id, int $state): void {  }

		/**
		 * Проверяет данные для изменения
		 * @param array $data - Данные
		 * @param array $errors - Ошибки
		 * @return array|null
		 */
		protected function validationDataUpdate(array $data, array & $errors): ?array {
			return validation($data, $this->validateDataUpdate, $this->names, $errors);
		}

		/**
		 * Задаёт поля для выборки
		 * @return void
		 */
		protected function setFieldsSelect(): void {  }

		/**
		 * Задаёт поля для просмотра
		 * @return void
		 */
		protected function setFieldsBrowse(): void {  }

		/**
		 * Задаёт поля для создания
		 * @return void
		 */
		protected function setFieldsCreate(): void {  }

		/**
		 * Задаёт поля для редактирования
		 * @return void
		 */
		protected function setFieldsUpdate(): void {  }

		/**
		 * Возвращает ссылки для навигации на странице выборки
		 * @return Accumulator
		 */
		public function getLinksNavigateSelect(): Accumulator {
			return new Accumulator();
		}

		/**
		 * Возвращает ссылки для навигации на странице просмотра
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksNavigateBrowse(array $item): Accumulator {
			$links = new Accumulator();

			if ($this->select->allow()) $links->push($this->select->hyperlink("<< {$this->titleSelect}", ['page' => old('page')->int(1)]));

			return $links;
		}

		/**
		 * Возвращает ссылки для навигации на странице создания
		 * @return Accumulator
		 */
		public function getLinksNavigateCreate(): Accumulator {
			$links = new Accumulator();

			if ($this->select->allow()) $links->push($this->select->hyperlink("<< {$this->titleSelect}", ['page' => old('page')->int(1)]));

			return $links;
		}

		/**
		 * Возвращает ссылки для навигации на странице редактирования
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksNavigateUpdate(array $item): Accumulator {
			$links = new Accumulator();

			if ($this->select->allow()) $links->push($this->select->hyperlink("<< {$this->titleSelect}", ['page' => old('page')->int(1)]));

			return $links;
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$id = isset($item['id']) ? (int)$item['id'] : 0;

			$links->push($this->browse->linkHrefID($id, $this->textDoBrowse, $item));
			$links->push($this->update->linkHrefID($id, $this->textDoUpdate, $item));
			$links->push($this->do_delete->linkHrefID($id, $this->textDoDelete, $item));

			return $links;
		}

		/**
		 * Возвращает модель редактора
		 * @return \Base\Model
		 */
		protected function model(): \Base\Model {
			return model($this->modelName, Models::SOURCE_EDITORS);
		}

	}