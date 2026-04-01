<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Locales;

	use Base\DB\Request\Select;
	use Base\Editor\Model;
	use stdClass;

	/**
	 * Model-editor
	 */
	class Aliases extends Model {
		const int USE_INACTIVE = 0;
		const int USE_ACTIVE = 1;

		public function __construct() {
			parent::__construct('craft', 'locales_aliases');
		}

		/**
		 * Возвращает запрос на выборку данных
		 * @param array ...$fields - Перечень полей
		 * @param stdClass $params - Параметры
		 * @return Select
		 */
		protected function getQuerySelect(array $fields, stdClass $params): Select {
			return $this->db
				->select()
				->fields('aliases.*', 'contexts.name context_name')
				->table("{$this->table} aliases")
				->join('locales_contexts contexts', 'contexts.id = aliases.context')
				->where('aliases.state', self::STATE_DELETE, '!=')
				->where('aliases.state', self::STATE_ERROR, '!=')
				->order('aliases.id');
		}

		/**
		 * Возвращает запрос на выборку одной записи
		 * @param int $id - Идентификатор
		 * @param string ...$fields - Перечень полей
		 * @return Select
		 */
		protected function getQueryBrowse(int $id, string ...$fields): Select {
			return $this->db
				->select()
				->fields('aliases.*', 'contexts.name context_name')
				->table("{$this->table} aliases")
				->join('locales_contexts contexts', 'contexts.id = aliases.context')
				->where('aliases.id', $id)
				->where('aliases.state', self::STATE_DELETE, '!=')
				->where('aliases.state', self::STATE_ERROR, '!=');
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
		 * Returns uses
		 * @return array
		 */
		public function getUses(): array {
			static $out = [
				self::USE_INACTIVE => __('No'),
				self::USE_ACTIVE => __('Yes'),
			];

			return $out;
		}

	}
