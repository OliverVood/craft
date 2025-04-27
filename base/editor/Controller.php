<?php

	declare(strict_types=1);

	namespace Base\Editor;

	use Base\Access\Feature;
	use Base\ControllerAccess;
	use Base\Data\Set;
	use Base\Models;
	use JetBrains\PhpStorm\NoReturn;
	use stdClass;

	require DIR_BASE_EDITOR . 'Link.php';
	require DIR_BASE_EDITOR . 'Fields.php';

	require DIR_BASE_EDITOR . 'actions/traits/Texts.php';
	require DIR_BASE_EDITOR . 'actions/traits/Entree.php';
	require DIR_BASE_EDITOR . 'actions/traits/Fields.php';
	require DIR_BASE_EDITOR . 'actions/traits/Validation.php';

	require DIR_BASE_EDITOR . 'actions/Access.php';
	require DIR_BASE_EDITOR . 'actions/Select.php';
	require DIR_BASE_EDITOR . 'actions/Browse.php';
	require DIR_BASE_EDITOR . 'actions/Create.php';
	require DIR_BASE_EDITOR . 'actions/Update.php';
	require DIR_BASE_EDITOR . 'actions/Delete.php';
	require DIR_BASE_EDITOR . 'actions/Status.php';

	/**
	 * Базовый класс для работы с контроллерами-редакторами
	 * @controller
	 */
	abstract class Controller extends ControllerAccess {
		use Link;

		protected string $modelName;

		public ?Actions\Access $access = null;
		public ?Actions\Select $select = null;
		public ?Actions\Browse $browse = null;
		public ?Actions\Create $create = null;
		public ?Actions\Update $update = null;
		public ?Actions\Delete $delete = null;
		public ?Actions\Status $status = null;

		public array $names = [];

		public stdClass $params;

		public function __construct(Feature $feature, string $modelName) {
			parent::__construct($feature);

			$this->modelName = $modelName;

			$this->links();

			$this->params = new stdClass();
		}

		/**
		 * Блок доступа
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 * @controllerMethod
		 */
		#[NoReturn] public function access(Set $data, mixed ...$params): void { $this->access->get($data, ...$params); }

		/**
		 * Блок выборки данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function select(Set $data, mixed ...$params): void { $this->select->get($data, ...$params); }

		/**
		 * Блок просмотра данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function browse(Set $data, mixed ...$params): void { $this->browse->get($data, ...$params); }

		/**
		 * Блок создания данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function create(Set $data, mixed ...$params): void { $this->create->get($data, ...$params); }

		/**
		 * Блок обновления данных
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function update(Set $data, mixed ...$params): void { $this->update->get($data, ...$params); }

		/**
		 * Устанавливает доступ
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function doAccess(Set $data, mixed ...$params): void { $this->access->set($data, ...$params); }

		/**
		 * Создание
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function doCreate(Set $data, mixed ...$params): void { $this->create->set($data, ...$params); }

		/**
		 * Обновление
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function doUpdate(Set $data, mixed ...$params): void { $this->update->set($data, ...$params); }

		/**
		 * Удаление
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function doDelete(Set $data, mixed ...$params): void { $this->delete->set($data, ...$params); }

		/**
		 * Изменение состояния
		 * @controllerMethod
		 * @param Set $data - Пользовательские данные
		 * @param mixed ...$params - Параметры запроса
		 * @return void
		 */
		#[NoReturn] public function setState(Set $data, mixed ...$params): void { $this->status->set($data, ...$params); }

		/**
		 * Возвращает модель редактора
		 * @return \Base\Model
		 */
		public function model(): \Base\Model {
			return model($this->modelName, Models::SOURCE_EDITORS);
		}

	}