<?php


	declare(strict_types=1);

	namespace Proj\Editors\Models\Access;

	use Base\Editor\Model;

	/**
	 * Модель прав пользователей
	 */
	class Users extends Model {
		public function __construct() {
			parent::__construct('craft', 'access_users');
		}

	}