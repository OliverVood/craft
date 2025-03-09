<?php

	namespace Proj\Editors\Models\User;

	use Base\Editor\Model;

	/**
	 * Модель групп
	 */
	class Group extends Model {
		private array $statesView;

		public function __construct() {
			parent::__construct('groups');

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