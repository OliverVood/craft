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

			$this->names = [
				'datecr' => __('Дата'),
				'cid' => __('ID Клиента'),
				'object' => __('Объект'),
				'action' => __('Действие'),
				'params' => __('Параметры'),
			];

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->datetime('datecr', $this->names['datecr']);
			$this->select->fields()->browse->text('cid', $this->names['cid']);
			$this->select->fields()->browse->text('object', $this->names['object']);
			$this->select->fields()->browse->text('action', $this->names['action']);
			$this->select->fields()->browse->text('params', $this->names['params']);
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