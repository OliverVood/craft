<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Access;

	use Base\Editor\Actions\Access;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;

	/**
	 * Контроллер-редактор прав групп
	 * @controller
	 */
	class Groups extends Controller {

		public function __construct() {
			parent::__construct(app()->features('groups'), 'access.groups');

			$this->actionAccess = new Access($this);
			$this->actionAccess->text('title', 'Права группы');
			$this->actionAccess->text('responseOkSet', 'Права группы установлены');
		}

		/**
		 * Возвращает ссылки для навигации
		 * @return Accumulator
		 */
		public function getLinksNavigateAccess(): Accumulator {
			$links = new Accumulator();

			if (allow('groups', 'select')) $links->push(linkRight('groups_select')->hyperlink('<< ' . __('Список групп'), ['page' => old('page')->int(1)]));

			return $links;
		}

	}