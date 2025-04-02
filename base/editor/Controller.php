<?php

	declare(strict_types=1);

	namespace Base\Editor;

	use Base\Access\Feature;
	use Base\ControllerAccess;
	use Base\Data\Set;
	use Base\Helper\Accumulator;
	use Base\Models;
	use JetBrains\PhpStorm\NoReturn;

	require DIR_BASE_EDITOR . 'Link.php';
	require DIR_BASE_EDITOR . 'Fields.php';

	require DIR_BASE_EDITOR . 'actions/traits/Texts.php';
	require DIR_BASE_EDITOR . 'actions/traits/Entree.php';
	require DIR_BASE_EDITOR . 'actions/traits/Fields.php';

	require DIR_BASE_EDITOR . 'actions/Access.php';
	require DIR_BASE_EDITOR . 'actions/Select.php';
	require DIR_BASE_EDITOR . 'actions/Browse.php';
	require DIR_BASE_EDITOR . 'actions/Create.php';
	require DIR_BASE_EDITOR . 'actions/Update.php';
	require DIR_BASE_EDITOR . 'actions/Delete.php';
	require DIR_BASE_EDITOR . 'actions/State.php';

	/**
	 * Базовый класс для работы с контроллерами-редакторами
	 * @controller
	 */
	abstract class Controller extends ControllerAccess {
		use Link;

		protected string $textDoAccess = 'Установить права доступа';
		protected string $textDoBrowse = 'Просмотреть';
		protected string $textDoUpdate = 'Изменить';
		protected string $textDoDelete = 'Удалить';
		protected string $textSetState = 'Изменить состояние';

		protected string $textDeleteConfirm = 'Удалить?';
		protected string $textSetStateConfirm = 'Изменить состояние?';

		protected string $textResponseOkCreate = 'Создано';
		protected string $textResponseOkUpdate = 'Изменено';
		protected string $textResponseOkDelete = 'Удалено';

		public ?Actions\Access $actionAccess = null;
		public ?Actions\Select $actionSelect = null;
		public ?Actions\Browse $actionBrowse = null;
		public ?Actions\Create $actionCreate = null;
		public ?Actions\Update $actionUpdate = null;
		public ?Actions\Delete $actionDelete = null;
		public ?Actions\State $actionState = null;

		protected int $id;
		protected string $name;
		protected string $title;
		protected string $modelName;

		public array $names = [];

		protected Fields $fieldsCreate;
		protected Fields $fieldsUpdate;

		protected array $validateDataUpdate = [];

		public function __construct(Feature $feature, string $modelName) {
			parent::__construct($feature);

			$this->modelName = $modelName;

			$this->links();

			$this->fieldsCreate = new Fields();
			$this->fieldsUpdate = new Fields();
		}

		/**
		 * Блок доступа
		 * @param Set $data - Пользовательские данные
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function access(Set $data): void { $this->actionAccess->get($data); }

		/**
		 * Блок выборки данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function select(Set $data): void { $this->actionSelect->get($data); }

		/**
		 * Блок просмотра данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function browse(Set $data): void { $this->actionBrowse->get($data); }

		/**
		 * Блок создания данных
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function create(): void { $this->actionCreate->get(); }

		/**
		 * Блок обновления данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function update(Set $data): void { $this->actionUpdate->get($data); }

		/**
		 * Устанавливает доступ
		 * @param Set $data - Пользовательские данные
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function doAccess(Set $data): void { $this->actionAccess->set($data); }

		/**
		 * Создание
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function doCreate(Set $data): void { $this->actionCreate->set($data); }

		/**
		 * Обновление
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function doUpdate(Set $data): void { $this->actionUpdate->set($data); }

		/**
		 * Удаление
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function doDelete(Set $data): void { $this->actionDelete->set($data); }

		/**
		 * Изменение состояния
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		public function setState(Set $data): void { $this->actionState->set($data); }

		/**
		 * Возвращает ссылки для навигации на странице создания
		 * @return Accumulator
		 */
		public function getLinksNavigateAccess(): Accumulator {
			$links = new Accumulator();

			if ($this->select->allow()) $links->push($this->select->hyperlink('<< ' . __($this->actionSelect->text('title')), ['page' => old('page')->int(1)]));

			return $links;
		}

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

			if ($this->select->allow()) $links->push($this->select->hyperlink('<< ' . __($this->actionSelect->text('title')), ['page' => old('page')->int(1)]));

			return $links;
		}

		/**
		 * Возвращает ссылки для навигации на странице создания
		 * @return Accumulator
		 */
		public function getLinksNavigateCreate(): Accumulator {
			$links = new Accumulator();

			if ($this->select->allow()) $links->push($this->select->hyperlink('<< ' . __($this->actionSelect->text('title')), ['page' => old('page')->int(1)]));

			return $links;
		}

		/**
		 * Возвращает ссылки для навигации на странице редактирования
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksNavigateUpdate(array $item): Accumulator {
			$links = new Accumulator();

			if ($this->select->allow()) $links->push($this->select->hyperlink('<< ' . __($this->actionSelect->text('title')), ['page' => old('page')->int(1)]));

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

			$links->push($this->browse->linkHrefID($id, __($this->textDoBrowse), $item));
			$links->push($this->update->linkHrefID($id, __($this->textDoUpdate), $item));
			$links->push($this->do_delete->linkHrefID($id, __($this->textDoDelete), $item));

			return $links;
		}

		/**
		 * Возвращает модель редактора
		 * @return \Base\Model
		 */
		public function model(): \Base\Model {
			return model($this->modelName, Models::SOURCE_EDITORS);
		}

	}