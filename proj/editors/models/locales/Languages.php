<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Locales;

	use Base\DB\Response;
	use Base\Editor\Model;

	/**
	 * Редактор-модель языков
	 */
	class Languages extends Model {
		private array $statesView;

		public function __construct() {
			parent::__construct('craft', 'locales_languages');

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

		public function getActive(string ...$fields): Response {
			return $this->db
				->select()
				->fields(...$fields)
				->table($this->table)
				->where('state', self::STATE_ACTIVE)
				->query();
		}

	}
