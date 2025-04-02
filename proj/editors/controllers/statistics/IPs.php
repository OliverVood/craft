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

			$this->actionSelect = new Select($this);
			$this->actionSelect->fields()->browse->date('datecr', 'Дата');
			$this->actionSelect->fields()->browse->text('cid', 'ID Клиента');
			$this->actionSelect->fields()->browse->int2IP('ip', 'IP адрес');
			$this->actionSelect->fields()->browse->text('path', 'Путь');
			$this->actionSelect->fields()->browse->text('params', 'Параметры');
			$this->actionSelect->text('title', 'Статистика запросов к серверу');
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