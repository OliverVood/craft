<?php

	namespace Proj\Editors\Controllers\Statistics;

	use Base\Editor\Actions\Select;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;

	/**
	 * Контроллер-редактор статистики действий
	 * @controller
	 */
	class Actions extends Controller {
		public function __construct() {
			parent::__construct(app()->features('statistics_actions'), 'statistics.actions');

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->datetime('datecr', 'Дата');
			$this->select->fields()->browse->text('cid', 'ID Клиента');
			$this->select->fields()->browse->text('object', 'Объект');
			$this->select->fields()->browse->text('action', 'Действие');
			$this->select->fields()->browse->text('params', 'Параметры');
			$this->select->text('title', 'Статистика действий клиентов');
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