<?php

	declare(strict_types=1);

	namespace Proj\Models;

	use Base\DB\DB;
	use Base\Model;

	/**
	 * Модель статистики
	 */
	class Statistics extends Model {
		const TABLE_STATISTICS_ACTIONS = 'statistics_act';
		const TABLE_STATISTICS_IP = 'statistics_ip';

		private DB $db;

		public function __construct() {
			parent::__construct();

			$this->db = app()->db('craft');
		}

		/**
		 * Добавляет статистику запросов
		 * @param int $clientId - Уникальный идентификатор клиента
		 * @param int $ip - IP v6
		 * @param string $url - URL
		 * @param string $method - Метод
		 * @param string $methodVirtual - Виртуальный метод
		 * @return bool
		 */
		public function addRequest(int $clientId, int $ip, string $url, string $method, string $methodVirtual): bool {
			$this->db
				->insert()
				->table(self::TABLE_STATISTICS_IP)
				->values([
					'cid' => $clientId,
					'ip' => $ip,
					'url' => $url,
					'method' => $method,
					'method_virtual' => $methodVirtual,
				])
				->query();

			return true;
		}

		/**
		 * Добавляет статистику по действиям пользователя
		 * @param int $clientId - Уникальный идентификатор клиента
		 * @param string $object - Объект
		 * @param string $action - Действие
		 * @param string $params - Параметры
		 * @return bool
		 */
		public function addActions(int $clientId, string $object, string $action, string $params): bool {
			$this->db
				->insert()
				->table(self::TABLE_STATISTICS_ACTIONS)
				->fields('uid', 'object', 'action', 'params')
				->values([
					'cid' => $clientId,
					'object' => $object,
					'action' => $action,
					'params' => $params,
				])
				->query();

			return true;
		}

	}