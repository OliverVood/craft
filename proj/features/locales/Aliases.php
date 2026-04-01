<?php

	declare(strict_types=1);

	namespace Proj\Features\Locales;

	use Base\Access\Feature;

	/**
	 * Feature
	 * @param int $id - Identifier
	 * @param string $name - Name
	 * @param string $title - Title
	 */
	class Aliases extends Feature {

		public function __construct(int $id, string $name, string $title = '') {
			parent::__construct($id, $name, $title);

			$this->rights->registration(self::RIGHT_ACCESS_ID, self::RIGHT_ACCESS_NAME, __('Permission'));
			$this->rights->registration(self::RIGHT_SELECT_ID, self::RIGHT_SELECT_NAME, __('Select'));
			$this->rights->registration(self::RIGHT_BROWSE_ID, self::RIGHT_BROWSE_NAME, __('Browse'));
			$this->rights->registration(self::RIGHT_CREATE_ID, self::RIGHT_CREATE_NAME, __('Create'));
			$this->rights->registration(self::RIGHT_UPDATE_ID, self::RIGHT_UPDATE_NAME, __('Update'));
			$this->rights->registration(self::RIGHT_DELETE_ID, self::RIGHT_DELETE_NAME, __('Delete'));
		}

	}
