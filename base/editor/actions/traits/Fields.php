<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions\Traits;

	/**
	 * Работа с перечнем полей
	 */
	trait Fields {
		protected \Base\Editor\Fields $fields;

		/**
		 * Возвращает перечень отображаемых полей
		 * @return \Base\Editor\Fields
		 */
		public function fields(): \Base\Editor\Fields {
			return $this->fields;
		}

	}