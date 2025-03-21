<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models;

	use Base\Editor\Model;

	/**
	 * Модель групп
	 */
	class Groups extends Model {
		private array $statesView;

		public function __construct() {
			parent::__construct('craft', 'groups');

			$this->statesView = [
				self::STATE_ERROR		=> __('Ошибка'),
				self::STATE_ACTIVE		=> __('Активная'),
				self::STATE_INACTIVE	=> __('Не активная'),
				self::STATE_DELETE		=> __('Удалена'),
			];
		}

		/**
		 * Подготовка данных перед созданием
		 * @param array $data - Данные
		 * @return void
		 */
		protected function prepareCreate(array & $data): void {
			$data['state'] = self::STATE_ACTIVE;
		}

		/**
		 * Возвращает состояния
		 * @return array
		 */
		public function getStates(): array {
			return $this->statesView;
		}

	}