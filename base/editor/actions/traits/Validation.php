<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions\Traits;

	/**
	 * Валидация
	 */
	trait Validation {
		private array $validate = [];

		/**
		 * Возвращает/устанавливает правила валидации
		 * @param array|null $rules - Правила
		 * @return array|null
		 */
		public function validate(?array $rules = null): ?array {
			if ($rules) $this->validate = $rules;

			return $this->validate;
		}

		/**
		 * Проверяет данные для создания
		 * @param array $data - Данные
		 * @param array $errors - Ошибки
		 * @return array|null
		 */
		private function validation(array $data, array & $errors): ?array {
			return validation($data, $this->validate(), $this->controller->names, $errors);
		}

	}