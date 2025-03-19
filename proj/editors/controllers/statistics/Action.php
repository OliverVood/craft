<?php

	namespace Proj\Editors\Controllers\Statistic;

	use Base\Editor\Controller;
	use Base\Helper\Accumulator;
	use Base\Route as BaseRoute;
	use Proj\Editors\Consts\Collections;

	class Action extends Controller {
		public function __construct() {
			parent::__construct(Collections\STATISTIC_ACTION['id'], Collections\STATISTIC_ACTION['name'], __('Статистика действий'), 'statistic.action', 'statistic.action');

			$this->titleSelect = __('Статистика действий клиентов');
		}

		/**
		 * Регистрация маршрутов
		 * @return void
		 */
		protected function regRoutes(): void {
			if (POINTER != 'xhr') return;

			BaseRoute::set("{$this->name}::select", "{$this->pathController}::select", BaseRoute::SOURCE_EDITORS);
		}

		/**
		 * Регистрирует коллекцию и права
		 * @return void
		 */
		protected function regActions(): void {
			$this->addCollection();

			$this->addRight(self::ACCESS_SETTING, 'setting', __('Назначение прав'));
			$this->addRight(self::ACCESS_SELECT, 'select', __('Выборка'));
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