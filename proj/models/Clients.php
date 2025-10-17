<?php

	declare(strict_types=1);

	namespace Proj\Models;

	use Base\DB\DB;
	use Base\Helper\Cryptography;
	use Base\Model;

	/**
	 * Модель клиентов
	 */
	class Clients extends Model {
		const TABLE_CLIENTS = 'clients';

		private ?int $id = null;
		private ?string $hash = null;

		private DB $db;

		public function __construct() {
			parent::__construct();

			$this->db = app()->db('craft');
		}

		/**
		 * Инициализация клиента
		 * @return void
		 */
		public function init(): void {
			[$id, $hash] = $this->getFromSession();

			if (!$id || !$hash) {
				[$id, $hash] = $this->getFromCookie();
				if (!$this->validate(isset($id) ? (int)$id : null, $hash)) {
					$id = null;
					$hash = null;
				}
			}

			$id = (int)$id;

			$newHash = Cryptography::generateBinToHex(32);

			if ($id && $hash) {
				$this->update($id, $newHash);
			} else {
				$id = $this->add($newHash);
			}

			$this->id = $id;
			$this->hash = $newHash;

			$this->setToSession();
			$this->setToCookie();
		}

		/**
		 * Возвращает идентификатор клиента
		 * @return int
		 */
		public function getId(): int {
			return $this->id;
		}

		/**
		 * Проверяет существование клиента по идентификатору и хешу
		 * @param int $id - Идентификатор клиента
		 * @param string $hash - Хеш
		 * @return bool
		 */
		private function hasClientByIdAndHash(int $id, string $hash): bool {
			$response = $this->db
				->select()
				->fields('id')
				->table(self::TABLE_CLIENTS)
				->where('id', $id)
				->where('hash', $hash)
				->limit(1)
				->query();

			return (bool)$response->get();
		}

		/**
		 * Добавляет клиента
		 * @param string $hash - Хеш
		 * @return int
		 */
		private function add(string $hash): int {
			$this->db
				->insert()
				->table(self::TABLE_CLIENTS)
				->values(['hash' => $hash])
				->query();

			return $this->db->insertId();
		}

		/**
		 * Обновляет хеш клиента
		 * @param int $id - Идентификатор клиента
		 * @param string $hash - Хеш
		 * @return void
		 */
		private function update(int $id, string $hash): void {
			$this->db
				->update()
				->table(self::TABLE_CLIENTS)
				->values(['hash' => $hash])
				->where('id', $id)
				->query();
		}

		/**
		 * Устанавливает данные клиента в сессию
		 * @return void
		 */
		private function setToSession(): void {
			session()->set($this->id, 'CLIENT', 'ID');
			session()->set($this->hash, 'CLIENT', 'HASH');
		}

		/**
		 * Возвращает данные клиента из сессии
		 * @return array
		 */
		private function getFromSession(): array {
			return [
				session()->get('CLIENT', 'ID'),
				session()->get('CLIENT', 'HASH'),
			];
		}

		/**
		 * Устанавливает данные клиента в куки
		 * @return void
		 */
		private function setToCookie(): void {
			cookie()->set('CLIENT_ID', (string)$this->id, time() + 86400000);
			cookie()->set('CLIENT_HASH', $this->hash, time() + 86400000);
		}

		/**
		 * Возвращает данные клиента из кук
		 * @return array
		 */
		private function getFromCookie(): array {
			return [
				cookie()->get('CLIENT_ID'),
				cookie()->get('CLIENT_HASH'),
			];
		}

		/**
		 * Проверяет данные клиента
		 * @param int|null $id - Идентификатор клиента
		 * @param string|null $hash - Хеш клиента
		 * @return bool
		 */
		private function validate(?int $id, ?string $hash): bool {
			if (!$id || !$hash) return false;

			$errors = [];
			$validated = validation([
				'id' => $id,
				'hash' => $hash,
			], [
				'id' => ['int', 'required'],
				'hash' => ['string', 'required', 'max:64'],
			], [], $errors);
			if ($errors) return false;

			if (!$this->hasClientByIdAndHash($validated['id'], $validated['hash'])) return false;

			return true;
		}

	}