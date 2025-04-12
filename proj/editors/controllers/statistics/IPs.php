<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Statistics;

	use Base\Editor\Actions\Select;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;

	/**
	 * Контроллер-редактор статистики посещаемости
	 * @controller
	 */
	class IPs extends Controller {
		public function __construct() {
			parent::__construct(app()->features('statistics_ips'), 'statistics.ips');

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->datetime('datecr', 'Дата');
			$this->select->fields()->browse->text('cid', 'ID Клиента');
			$this->select->fields()->browse->int2IP('ip', 'IP адрес');
			$this->select->fields()->browse->text('path', 'Путь');
			$this->select->fields()->browse->text('params', 'Параметры');
			$this->select->text('title', 'Статистика запросов к серверу');
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