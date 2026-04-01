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
				'url' => __('URL'),
				'method' => __('Метод'),
				'method_virtual' => __('Виртуальный метод'),
			];

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->datetime('datecr', $this->names['datecr']);
			$this->select->fields()->browse->text('cid', $this->names['cid']);
			$this->select->fields()->browse->int2IP('ip', $this->names['ip']);
			$this->select->fields()->browse->text('url', $this->names['url']);
			$this->select->fields()->browse->text('method', $this->names['method']);
			$this->select->fields()->browse->text('method_virtual', $this->names['method_virtual']);
			$this->select->text('title', __('Статистика запросов к серверу'));
		}

		/**
		 * Возвращает ссылки управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		public function getLinksManage(array $item): Accumulator {
			return new Accumulator();
		}

	}