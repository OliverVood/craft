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

			$this->access = new Access($this);
			$this->access->fnGetLinksNavigate = fn () => $this->getLinksNavigate();
			$this->access->validate([
				'id' => ['required', 'int', 'foreign:craft,groups,id'],
			]);
			$this->access->text('title', 'Права группы');
			$this->access->text('responseOkSet', 'Права группы установлены');
		}

		/**
		 * Возвращает ссылки навигации
		 * @return Accumulator
		 */
		public function getLinksNavigate(): Accumulator {
			$links = new Accumulator();

			if (allow('groups', 'select')) $links->push(linkRight('groups_select')->hyperlink('<< ' . __('Список групп'), ['page' => old('page')->int(1)]));

			return $links;
		}

	}