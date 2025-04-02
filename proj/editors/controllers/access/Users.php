<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Access;

	use Base\Editor\Actions\Access;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;

	/**
	 * Контроллер-редактор прав пользователей
	 * @controller
	 */
	class Users extends Controller {

		public function __construct() {
			parent::__construct(app()->features('users'), 'access.users');

			$this->actionAccess = new Access($this);
			$this->actionAccess->text('title', 'Права пользователя');
			$this->actionAccess->text('responseOkSet', 'Права пользователя установлены');
		}

		/**
		 * Возвращает ссылки для навигации
		 * @return Accumulator
		 */
		public function getLinksNavigateAccess(): Accumulator {
			$links = new Accumulator();

			if (allow('users', 'select')) $links->push(linkRight('users_select')->hyperlink('<< ' . __('Список пользователей'), ['page' => old('page')->int(1)]));

			return $links;
		}

	}