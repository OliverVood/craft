<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Locales;

	use Base\Editor\Model;

	/**
	 * Model-editor
	 */
	class Contexts extends Model {
		private array $statesView;

		public function __construct() {
			parent::__construct('craft', 'locales_contexts');

			$this->statesView = [
				self::STATE_ERROR		=> __('Error'),
				self::STATE_ACTIVE		=> __('Active'),
				self::STATE_INACTIVE	=> __('Inactive'),
				self::STATE_DELETE		=> __('Deleted'),
			];
		}

		/**
		 * Prepare data
		 * @param array $data - Data
		 * @return void
		 */
		protected function prepareCreate(array & $data): void {
			$data['state'] = self::STATE_ACTIVE;
		}

		/**
		 * Returns statuses
		 * @return array
		 */
		public function getStates(): array {
			return $this->statesView;
		}

	}
