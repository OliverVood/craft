<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Site;

	use Base\Data\Set;
	use Base\Editor\Actions\Browse;
	use Base\Editor\Actions\Create;
	use Base\Editor\Actions\Delete;
	use Base\Editor\Actions\Select;
	use Base\Editor\Actions\Update;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Editors\Models\Site\Change as Model;

	/**
	 * Контроллер-редактор изменения
	 * @controller
	 */
	class Change extends Controller {
		public function __construct() {
			parent::__construct(app()->features('changes'), 'site.change');

			$this->names = [
				'state' =>  __('Состояние'),
				'header' => __('Заголовок'),
				'content' => __('Текст'),
				'cover' => __('Обложка'),
			];

			/** @var Model $model */ $model = $this->model();

			$this->select = new Select($this);
			$this->select->fnGetLinksNavigate = fn () => $this->getLinksNavigateSelect();
			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->fromArray('state', $this->names['state'], $model->getStates());
			$this->select->fields()->browse->text('header', $this->names['header']);
			$this->select->text('title', 'Список конкретных изменений');

			$this->browse = new Browse($this);
			$this->browse->fields()->browse->fromArray('state', $this->names['state'], $model->getStates());
			$this->browse->fields()->browse->text('header', $this->names['header']);
			$this->browse->fields()->browse->text('content', $this->names['content']);
			$this->browse->text('title', 'Просмотр изменения');

			$this->create = new Create($this);
			$this->create->fnPrepareView = fn (array & $item) => $this->prepareViewCreate($item);
			$this->create->fnPrepareData = fn (array & $item) => $this->prepareDataCreate($item);
			$this->create->fields()->edit->text('header', $this->names['header']);
			$this->create->fields()->edit->textarea('content', $this->names['content']);
			$this->create->fields()->edit->file('cover', $this->names['cover'], __('Выберите обложку'), '.jpg, .jpeg, .png');
			$this->create->validate([
				'cid' => ['required', 'int', 'foreign:craft,changes,id'],
				'header'	=> ['required', 'string', 'max:255'],
				'content'	=> ['required', 'string'],
			]);
			$this->create->text('title', 'Добавление изменения');
			$this->create->text('do', 'Добавить изменение');
			$this->create->text('responseOk', 'Изменение добавлено');

			$this->update = new Update($this);
			$this->update->fnPrepareView = fn (int $id, array & $item) => $this->prepareViewUpdate($id, $item);
			$this->update->fields()->edit->select('state', $this->names['state'], $model->getStates());
			$this->update->fields()->edit->text('header', $this->names['header']);
			$this->update->fields()->edit->textarea('content', $this->names['content']);
			$this->update->fields()->edit->file('cover', $this->names['cover'], __('Выберите обложку'), '.jpg, .jpeg, .png');
			$this->update->validate([
				'header'	=> ['required', 'string', 'max:255'],
				'content'	=> ['required', 'string'],
			]);
			$this->update->text('title', 'Редактирование изменения');
			$this->update->text('responseOk', 'Изменение редактировано');

			$this->delete = new Delete($this);
			$this->delete->text('confirm', 'Удалить изменение?');
			$this->delete->text('responseOk', 'Изменение удалено');
		}

		/**
		 * Блок выборки данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function select(Set $data, mixed ...$params): void {
			[$this->params->changes] = $params;
			parent::select($data, ...$params);
		}

		/**
		 * Блок просмотра данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function browse(Set $data, mixed ...$params): void {
			[$this->params->changes, $id] = $params;
			parent::browse($data, $id);
		}

		/**
		 * Блок создания данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function create(Set $data, mixed ...$params): void {
			[$this->params->changes] = $params;
			parent::create($data, ...$params);
		}

		/**
		 * Блок обновления данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function update(Set $data, mixed ...$params): void {
			[$this->params->changes, $id] = $params;
			parent::update($data, $id);
		}

		/**
		 * Создание
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function doCreate(Set $data, mixed ...$params): void {
			[$this->params->changes] = $params;
			parent::doCreate($data, ...$params);
		}

		/**
		 * Обновление
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function doUpdate(Set $data, mixed ...$params): void {
			[$this->params->changes, $id] = $params;
			$this->update->set($data, $id);
		}

		/**
		 * Удаление
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function doDelete(Set $data, mixed ...$params): void {
			[$this->params->changes, $id] = $params;
			parent::doDelete($data, $id);
		}

		/**
		 * Регистрация ссылок
		 * @return void
		 */
		protected function links(): void {
			$this->linkAccess = linkRight('change_access', false);
			$this->linkSelect = linkRight('change_select', false);
			$this->linkBrowse = linkRight('change_browse', false);
			$this->linkCreate = linkRight('change_create', false);
			$this->linkUpdate = linkRight('change_update', false);

			$this->linkDoAccess = linkRight('change_do_access', false);
			$this->linkDoCreate = linkRight('change_do_create', false);
			$this->linkDoUpdate = linkRight('change_do_update', false);
			$this->linkDoDelete = linkRight('change_do_delete', false);
			$this->linkSetState = linkRight('change_set_state', false);
		}

		/**
		 * Возвращает ссылки навигации
		 * @return Accumulator
		 */
		public function getLinksNavigateSelect(): Accumulator {
			$links = new Accumulator();

			if ($this->allow('select')) $links->push(linkInternal('changes_select')->hyperlink('<< ' . __('Изменения'), array_merge(['page' => old('page')->int(1)], (array)$this->params)));
			if ($this->allow('create')) $links->push($this->linkCreate->linkHrefID($this->params->changes, $this->create->__('do'), (array)$this->params));

			return $links;
		}

		/**
		 * Подготовка данных для блока создания
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareViewCreate(array & $item): void {
			$item['changes'] = $this->params->changes;
		}

		/**
		 * Подготовка данных для блока обновления
		 * @param int $id - Идентификатор
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareViewUpdate(int $id, array & $item): void {
			$item['changes'] = $this->params->changes;
		}

		/**
		 * Подготовка данных перед созданием
		 * @param array $data - Данные
		 * @return void
		 */
		private function prepareDataCreate(array & $data): void {
			$data['cid'] = $this->params->changes;
		}

	}