<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Statistics;

	use Base\Editor\Controller;
	use Base\Helper\Accumulator;

	class IPs extends Controller {
		public function __construct() {
			parent::__construct(app()->features('statistics_ips'), 'statistics.ips'/*Collections\STATISTIC_IP['id'], Collections\STATISTIC_IP['name'], __('Статистика запросов'), 'statistic.ip'*/);

			$this->titleSelect = __('Статистика запросов к серверу');
		}

		/**
		 * Регистрация маршрутов
		 * @return void
		 */
		protected function regRoutes(): void {
//			if (POINTER != 'xhr') return;
//
//			BaseRoute::set("{$this->name}::select", "{$this->pathController}::select", BaseRoute::SOURCE_EDITORS);
		}

		/**
		 * Регистрирует коллекцию и права
		 * @return void
		 */
		protected function regActions(): void {
//			$this->addCollection();
//
//			$this->addRight(self::ACCESS_SETTING, 'setting', __('Назначение прав'));
//			$this->addRight(self::ACCESS_SELECT, 'select', __('Выборка'));
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