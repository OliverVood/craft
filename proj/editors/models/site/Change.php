<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Site;

	use Base\DB\Request\Select;
	use Base\Editor\Model;
	use stdClass;

	/**
	 * Модель изменения
	 */
	class Change extends Model {
		const PATH_COVER = DIR_RESOURCE_IMAGE . 'changes/';

		private array $statesView;

		public function __construct() {
			parent::__construct('craft', 'change');

			$this->statesView = [
				self::STATE_DRAFT		=> __('Черновик'),
				self::STATE_ACTIVE		=> __('Активная'),
				self::STATE_INACTIVE	=> __('Не активная'),
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
				->where('cid', $params->changes)
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
		}

		/**
		 * Создание записи
		 * @param array $data - Данные
		 * @return int|null
		 */
		public function create(array $data): ?int {
			if (!$id = parent::create($data)) return null;

			if (!$_FILES['cover']['error']) {
				[$hash, $ext] = $this->saveCover($id, $_FILES['cover']);
				$this->db
					->update()
					->table($this->table)
					->values(['hash' => $hash, 'ext' => $ext])
					->where('id', $id)
					->query();
			}

			return $id;
		}

		/**
		 * Обновление записи
		 * @param array $data - Данные
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		public function update(array $data, int $id): bool {
			if (!$_FILES['cover']['error']) {
				$this->deleteCover($id);
				[$data['hash'], $data['ext']] = $this->saveCover($id, $_FILES['cover']);
			}

			if (!parent::update($data, $id)) return false;

			return true;
		}

		/**
		 * Сохраняет обложку новостей
		 * @param int $id - Идентификатор новости
		 * @param array $file - Файл
		 * @return array
		 */
		public function saveCover(int $id, array $file): array {
			$temp_path = $file['tmp_name'];
			$temp_name = $file['name'];
			$dir = self::PATH_COVER;
			$hash = hash_file('md5', $temp_path);
			$info = pathinfo($temp_name);
			$ext = $info['extension'];
			$name = "{$hash}.{$id}.{$ext}";

			if (!is_dir($dir)) mkdir($dir, 0777, true);
			move_uploaded_file($temp_path, $dir . $name);

			return [$hash, $ext];
		}

		public function deleteCover($id): void {
			$response = $this->db
				->select()
				->fields('id', 'hash', 'ext')
				->table($this->table)
				->where('id', $id)
				->limit(1)
				->query();

			if (!$row = $response->get()) return;

			$old_file = "{$row['hash']}.{$row['id']}.{$row['ext']}";

			unlink(self::PATH_COVER . $old_file);
		}

	}