<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Site;

	use Base\Editor\Actions\Browse;
	use Base\Editor\Actions\Delete;
	use Base\Editor\Actions\Select;
	use Base\Editor\Actions\Status;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;
	use Proj\Editors\Models\Site\Feedback as Model;

	/**
	 * Контроллер-редактор обратной связи
	 * @controller
	 */
	class Feedback extends Controller {
		public function __construct() {
			parent::__construct(app()->features('feedback'), 'site.feedback');

			/** @var Model $model */ $model = $this->model();

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->select->fields()->browse->text('name', __('Имя'));
			$this->select->fields()->browse->text('contacts', __('Контакт'));
			$this->select->fields()->browse->text('letter', __('Тема сообщения'));
			$this->select->fields()->browse->datetime('datecr', __('Дата'), 'd.m.Y H:i');
			$this->select->text('title', 'Список обратной связи');

			$this->browse = new Browse($this);
			$this->browse->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->browse->fields()->browse->datetime('datecr', __('Дата'), 'd.m.Y H:i');
			$this->browse->fields()->browse->text('name', __('Имя'));
			$this->browse->fields()->browse->text('contacts', __('Контакт'));
			$this->browse->fields()->browse->text('letter', __('Тема сообщения'));
			$this->browse->fields()->browse->text('content', __('Содержание'));
			$this->browse->text('title', 'Обратная связь');

			$this->delete = new Delete($this);
			$this->delete->text('confirm', 'Удалить запись?');
			$this->delete->text('responseOk', 'Запись удалена');

			$this->status = new Status($this);
			$this->status->text('confirm', 'Проверить запись?');
			$this->status->text('do', 'Проверить запись');
			$this->status->text('responseOk', 'Запись проверена');
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		private function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$id = isset($item['id']) ? (int)$item['id'] : 0;
			$state = isset($item['state']) ? (int)$item['state'] : 0;

			$links->push($this->linkBrowse->linkHrefID($id, $this->browse->__('do'), array_merge($item, (array)$this->params)));
			$links->push($state == Model::STATE_NEW ? $this->linkSetState->linkHrefID($id, $this->status->__('do'), array_merge($item, (array)$this->params, ['status' => Model::STATE_DONE])) : '');
			$links->push($this->linkDoDelete->linkHrefID($id, $this->delete->__('do'), array_merge($item, (array)$this->params)));

			return $links;
		}

	}