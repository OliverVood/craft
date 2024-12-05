<?php

	namespace Base\Editor;

	use Base\Data\Set\Input;
	use Base\Helper\Accumulator;
	use Base\Helper\Pagination;
	use Base\Helper\Response;
	use Base\View;

	require DIR_BASE . 'editor/Access.php';
	require DIR_BASE . 'editor/Link.php';
	require DIR_BASE . 'editor/Route.php';
	require DIR_BASE . 'editor/Texts.php';
	require DIR_BASE . 'editor/Fields.php';

	/**
	 * Базовый класс для работы с контроллерами-редакторами
	 * @controller
	 */
	abstract class Controller extends \Base\Controller {
		use Access;
		use Link;
		use Route;
		use Texts;

		protected int $id;
		protected string $name;
		protected string $nameController;
		protected string $title;

		protected string $tplSelect = 'admin.editor.select';
		protected string $tplBrowse = 'admin.editor.browse';
		protected string $tplCreate = 'admin.editor.create';
		protected string $tplUpdate = 'admin.editor.update';

		protected Fields $fieldsSelect;
		protected Fields $fieldsBrowse;
		protected Fields $fieldsCreate;
		protected Fields $fieldsUpdate;

		protected int $page_entries = 10;

		public function __construct(int $id, string $name, string $title) {
			parent::__construct($id);

			$this->id = $id;
			$this->name = $name;
			$this->nameController = implode('.', explode('_', $name));
			$this->title = $title;

			$this->regActions();
			$this->regLinks();
			$this->regRoutes();

			$this->fieldsSelect = new Fields();
			$this->fieldsBrowse = new Fields();
			$this->fieldsCreate = new Fields();
			$this->fieldsUpdate = new Fields();
		}

		/**
		 * Блок выборки данных
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @param int $redirectPage - Текущая страница для перенаправления
		 * @return void
		 */
		public function select(Input $input, int $redirectPage = 0): void {
			if (!$this->allowSelect()) Response::SendNoticeError(__($this->textResponseErrorAccess));

			$page = $redirectPage ?: $input->defined('page')->int(1);

			/** @var Model $model */ $model = modelEditor($this->nameController);
			[$items, $ext] = $model->select(['*'], $page, $this->page_entries);

			$this->prepareSelect($items);

			$this->setFieldsSelect();

			$title = __($this->titleSelect);
			$fields = $this->fieldsSelect;
			$pagination = $this->page_entries ? new Pagination($this->select, $ext['page']['current'], $ext['page']['count']) : null;
			$editor = $this;

			Response::pushHistory($this->select, ['page' => $page]);
			Response::pushSection('content', View::get($this->tplSelect, compact('title', 'fields', 'items' ,'pagination', 'editor')));
			Response::SendJSON();
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

			if ($id < 1) Response::SendNoticeError(__($this->textResponseErrorNotFound));

			if (!$this->allowBrowse($id)) Response::SendNoticeError(__($this->textResponseErrorAccess));

			/** @var Model $model */ $model = modelEditor($this->nameController);
			$item = $model->browse($id, ['*']);

			$this->prepareBrowse($id, $item);

			$this->setFieldsBrowse();

			if (!$item) Response::SendNoticeError(__($this->textResponseErrorNotFound));

			$title = __($this->titleBrowse) . " #{$id}";
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
			if (!$this->allowCreate()) Response::SendNoticeError(__($this->textResponseErrorAccess));

			$this->prepareCreate();

			$this->setFieldsCreate();

			$title = __($this->titleCreate);
			$fields = $this->fieldsCreate;
			$action = $this->do_create;
			$textBtn = __($this->textBtnCreate);
			$editor = $this;

			Response::pushHistory($this->create);
			Response::pushSection('content', View::get($this->tplCreate, compact('title', 'fields', 'action', 'textBtn', 'editor')));
			Response::SendJSON();
		}

		/**
		 * Блок обновления данных
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @return void
		 */
		public function update(Input $input): void {
			$id = $input->defined('id')->int(0);

			if ($id < 1) Response::SendNoticeError(__($this->textResponseErrorNotFound));

			if (!$this->allowUpdate($id)) Response::SendNoticeError(__($this->textResponseErrorAccess));

			/** @var Model $model */ $model = modelEditor($this->nameController);
			$item = $model->browse($id, ['*']);

			$this->prepareUpdate($id, $item);

			$this->setFieldsUpdate();

			$title = __($this->titleUpdate) . " #{$id}";
			$fields = $this->fieldsUpdate;
			$action = $this->do_update;
			$textBtn = __($this->textBtnUpdate);
			$editor = $this;

			Response::pushHistory($this->update, ['id' => $id]);
			Response::pushSection('content', View::get($this->tplUpdate, compact('title', 'fields', 'id', 'item', 'action', 'textBtn', 'editor')));
			Response::SendJSON();
		}

		/**
		 * Подготовка данных для блока выборки
		 * @param \Base\DB\Response $items
		 * @return void
		 */
		protected function prepareSelect(\Base\DB\Response & $items): void {  }

		/**
		 * Подготовка данных для блока просмотра
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		protected function prepareBrowse(int $id, array & $item): void {  }

		/**
		 * Подготовка данных для блока создания
		 * @return void
		 */
		protected function prepareCreate(): void {  }

		/**
		 * Подготовка данных для блока обновления
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		protected function prepareUpdate(int $id, array & $item): void {  }

		/**
		 * Создание
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @return void
		 */
		public function doCreate(Input $input): void {
			if (!$this->allowCreate()) Response::SendNoticeError(__($this->textResponseErrorAccess));

			$data = $input->defined()->all();

			/** @var Model $model */ $model = modelEditor($this->nameController);
			if (!$id = $model->create($data)) Response::sendNoticeError(__($this->textResponseErrorCreate));

			Response::pushNoticeOk(__($this->textResponseOkCreate));
			$this->browse($input, $id);
		}

		/**
		 * Обновление
		 * @controllerMethod
		 * @param Input $input - Входные данные
		 * @return void
		 */
		public function doUpdate(Input $input): void {
			$id = $input->defined('id')->int(0);

			if ($id < 1) Response::SendNoticeError(__($this->textResponseErrorNotFound));

			if (!$this->allowUpdate($id)) Response::SendNoticeError(__($this->textResponseErrorAccess));

			$data = $input->defined()->all();

			/** @var Model $model */ $model = modelEditor($this->nameController);
			if (!$model->update($data, $id)) Response::sendNoticeError(__($this->textResponseErrorUpdate));

			Response::pushNoticeOk(__($this->textResponseOkUpdate));
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

			if ($id < 1) Response::SendNoticeError(__($this->textResponseErrorNotFound));

			if (!$this->allowDelete($id)) Response::SendNoticeError(__($this->textResponseErrorAccess));

			/** @var Model $model */ $model = modelEditor($this->nameController);
			if (!$model->delete($id)) Response::sendNoticeError(__($this->textResponseErrorDelete));

			Response::pushNoticeOk(__($this->textResponseOkDelete));
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

			if ($id < 1) Response::SendNoticeError(__($this->textResponseErrorNotFound));
			if ($state < 1) Response::SendNoticeError(__($this->textResponseErrorState));

			if (!$this->allowState($id)) Response::SendNoticeError(__($this->textResponseErrorAccess));

			/** @var Model $model */ $model = modelEditor($this->nameController);
			if (!$model->setState($id, $state)) Response::sendNoticeError(__($this->textResponseErrorState));

			Response::pushNoticeOk(__($this->textResponseOkSetState));
			$this->select($input, $input->old('page')->int(1));
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

			if ($this->select->allow()) $links->push($this->select->linkHref('<< ' . __($this->titleSelect), ['page' => old('page')->int(1)]));

			return $links;
		}

		/**
		 * Возвращает ссылки для навигации на странице создания
		 * @return Accumulator
		 */
		public function getLinksNavigateCreate(): Accumulator {
			$links = new Accumulator();

			if ($this->select->allow()) $links->push($this->select->linkHref('<< ' . __($this->titleSelect), ['page' => old('page')->int(1)]));

			return $links;
		}

		/**
		 * Возвращает ссылки для навигации на странице редактирования
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksNavigateUpdate(array $item): Accumulator {
			$links = new Accumulator();

			if ($this->select->allow()) $links->push($this->select->linkHref('<< ' . __($this->titleSelect), ['page' => old('page')->int(1)]));

			return $links;
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$links->push($this->browse->linkHrefID($item['id'] ?? 0, __($this->textDoBrowse), $item));
			$links->push($this->update->linkHrefID($item['id'] ?? 0, __($this->textDoUpdate), $item));
			$links->push($this->do_delete->linkHrefID($item['id'] ?? 0, __($this->textDoDelete), $item));

			return $links;
		}

	}