<?php

	namespace Proj\Editors\Controllers\Statistics;

	use Base\Editor\Actions\Select;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;

	/**
	 * Контроллер-редактор статистики действий
	 */
	class Actions extends Controller {
		public function __construct() {
			parent::__construct(app()->features('statistics_actions'), 'statistics.actions');

			$this->actionSelect = new Select($this);
			$this->actionSelect->fields()->browse->date('datecr', 'Дата');
			$this->actionSelect->fields()->browse->text('cid', 'ID Клиента');
			$this->actionSelect->fields()->browse->text('object', 'Объект');
			$this->actionSelect->fields()->browse->text('action', 'Действие');
			$this->actionSelect->fields()->browse->text('params', 'Параметры');
			$this->actionSelect->text('title', 'Статистика действий клиентов');
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksManage(array $item): Accumulator {
			return new Accumulator();
		}

	}