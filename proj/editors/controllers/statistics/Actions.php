<?php

	namespace Proj\Editors\Controllers\Statistics;

	use Base\Editor\Controller;
	use Base\Helper\Accumulator;

	/**
	 * Контроллер-редактор статистики действий
	 */
	class Actions extends Controller {
		public function __construct() {
			parent::__construct(app()->features('statistics_actions'), 'statistics.actions');

			$this->titleSelect = 'Статистика действий клиентов';
		}

		/**
		 * Задаёт поля для выборки
		 * @return void
		 */
		protected function setFieldsSelect(): void {
			$this->fieldsSelect->browse->date('datecr', 'Дата');
			$this->fieldsSelect->browse->text('cid', 'ID Клиента');
			$this->fieldsSelect->browse->text('object', 'Объект');
			$this->fieldsSelect->browse->text('action', 'Действие');
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