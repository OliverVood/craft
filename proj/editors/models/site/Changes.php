<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Site;

	use Base\DB\Request\Select;
	use Base\Editor\Model;
	use stdClass;

	/**
	 * Модель изменений
	 */
	class Changes extends Model {
		private array $statesView;

		public function __construct() {
			parent::__construct('craft', 'changes');

			$this->statesView = [
				self::STATE_DRAFT		=> __('Черновик'),
				self::STATE_ACTIVE		=> __('Активный'),
				self::STATE_INACTIVE	=> __('Не активный'),
			];
		}

		/**
		 * Возвращает состояния
		 * @return array
		 */
		public function getStates(): array {
			return $this->statesView;
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
				->fields(...$fields)
				->table($this->table)
				->where('state', self::STATE_DELETE, '!=')
				->where('state', self::STATE_ERROR, '!=')
				->order('datecr', 'DESC')
				->order('id');
		}

		/**
		 * Подготовка данных перед созданием
		 * @param array $data - Данные
		 * @return void
		 */
		protected function prepareCreate(array & $data): void {
			$data['state'] = self::STATE_DRAFT;
			$data['datepb'] = $data['datepb']->format('Y-m-d H:i:s');
		}

		/**
		 * Подготовка данных перед изменением
		 * @param array $data - Данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		protected function prepareUpdate(array & $data, int $id): void {
			$data['datepb'] = $data['datepb']->format('Y-m-d H:i:s');
		}

	}