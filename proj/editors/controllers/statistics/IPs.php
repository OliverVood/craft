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
			parent::__construct(feature('statistics_ips'), 'statistics.ips');

			$this->names = [
				'datecr' => __('Дата'),
				'cid' => __('ID Клиента'),
				'ip' => __('IP адрес'),
				'path' => __('Путь'),
				'params' => __('Параметры'),
			];

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->datetime('datecr', $this->names['datecr']);
			$this->select->fields()->browse->text('cid', $this->names['cid']);
			$this->select->fields()->browse->int2IP('ip', $this->names['ip']);
			$this->select->fields()->browse->text('path', $this->names['path']);
			$this->select->fields()->browse->text('params', $this->names['params']);
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