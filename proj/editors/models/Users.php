<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models;

	use Base\DB\Request\Select;
	use Base\Editor\Model;
	use stdClass;

	/**
	 * Модель пользователей
	 */
	class Users extends Model {
		private array $statesView;

		public function __construct() {
			parent::__construct('craft', 'users');

			$this->statesView = [
				self::STATE_ERROR		=> __('Ошибка'),
				self::STATE_ACTIVE		=> __('Активный'),
				self::STATE_INACTIVE	=> __('Не активный'),
				self::STATE_BLOCK		=> __('Заблокированный'),
				self::STATE_DELETE		=> __('Удалён'),
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

		/**
		 * Возвращает запрос на выборку данных
		 * @param array ...$fields - Перечень полей
		 * @param stdClass $params - Параметры
		 * @return Select
		 */
		protected function getQuerySelect(array $fields, stdClass $params): Select {
			return $this->db
				->select()
				->fields('users.*', 'groups.name group')
				->table($this->table)
				->join('groups', 'groups.id = users.gid')
				->where('users.state', self::STATE_DELETE, '!=')
				->where('users.state', self::STATE_ERROR, '!=')
				->order('users.id');
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
				->fields('users.*', 'groups.name group')
				->table($this->table)
				->join('groups', 'groups.id = users.gid')
				->where('users.id', $id)
				->where('users.state', self::STATE_DELETE, '!=')
				->where('users.state', self::STATE_ERROR, '!=');
		}

	}