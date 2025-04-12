<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Access;

	use Base\Editor\Model;

	/**
	 * Модель прав групп
	 */
	class Groups extends Model {
		const PERMISSIONS = [];

		public function __construct() {
			parent::__construct('craft', 'access_groups');
		}

	}