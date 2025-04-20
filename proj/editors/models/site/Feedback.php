<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Site;

	use Base\DB\Request\Select;
	use Base\Editor\Model;
	use stdClass;

	/**
	 * Модель обратной связи
	 */
	class Feedback extends Model {
		const STATE_NEW						= 1;
		const STATE_DONE					= 2;

		private array $statesView;

		public function __construct() {
			parent::__construct('craft', 'feedback');

			$this->states = [
				self::STATE_NEW => [
					self::STATE_DONE
				]
			];

			$this->statesView = [
				self::STATE_NEW				=> __('Новая'),
				self::STATE_DONE			=> __('Проверена'),
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

	}