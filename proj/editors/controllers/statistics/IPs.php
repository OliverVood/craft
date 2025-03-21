<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Statistics;

	use Base\Editor\Controller;
	use Base\Helper\Accumulator;

	/**
	 * Контроллер-редактор статистики посещаемости
	 * @controller
	 */
	class IPs extends Controller {
		public function __construct() {
			parent::__construct(app()->features('statistics_ips'), 'statistics.ips');

			$this->titleSelect = 'Статистика запросов к серверу';
		}

		/**
		 * Задаёт поля для выборки
		 * @return void
		 */
		protected function setFieldsSelect(): void {
			$this->fieldsSelect->browse->date('datecr', 'Дата');
			$this->fieldsSelect->browse->text('cid', 'ID Клиента');
			$this->fieldsSelect->browse->int2IP('ip', 'IP адрес');
			$this->fieldsSelect->browse->text('path', 'Путь');
			$this->fieldsSelect->browse->text('params', 'Параметры');
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