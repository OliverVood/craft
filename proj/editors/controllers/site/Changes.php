<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Site;

	use Base\Editor\Actions\Browse;
	use Base\Editor\Actions\Create;
	use Base\Editor\Actions\Delete;
	use Base\Editor\Actions\Select;
	use Base\Editor\Actions\Update;
	use Base\Editor\Controller;
	use Base\Helper\Accumulator;
	use Proj\Editors\Models\Site\Changes as Model;

	/**
	 * Контроллер-редактор изменений
	 * @controller
	 */
	class Changes extends Controller {
		public function __construct() {
			parent::__construct(app()->features('changes'), 'site.changes');

			$this->names = [
				'state'			=> __('Состояние'),
				'datepb'		=> __('Дата публикации'),
				'work_header'	=> __('Рабочий заголовок'),
				'header'		=> __('Заголовок'),
				'cover'			=> __('Обложка'),
			];

			/** @var Model $model */ $model = $this->model();

			$this->select = new Select($this);
			$this->select->fnGetLinksManage = fn (array $item): Accumulator => $this->getLinksManage($item);
			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->fromArray('state', $this->names['state'], $model->getStates());
			$this->select->fields()->browse->datetime('datepb', $this->names['datepb'], 'd.m.Y H:i');
			$this->select->fields()->browse->text('work_header', $this->names['work_header']);
			$this->select->fields()->browse->text('header', $this->names['header']);
			$this->select->text('title', __('Изменения'));

			$this->browse = new Browse($this);
			$this->browse->fields()->browse->text('id', '#');
			$this->browse->fields()->browse->fromArray('state', $this->names['state'], $model->getStates());
			$this->browse->fields()->browse->datetime('datepb', $this->names['datepb'], 'd.m.Y H:i');
			$this->browse->fields()->browse->text('work_header', $this->names['work_header']);
			$this->browse->fields()->browse->text('header', $this->names['header']);
			$this->browse->text('title', 'Просмотр изменений');

			$this->create = new Create($this);
			$this->create->fields()->edit->text('work_header', $this->names['work_header']);
			$this->create->fields()->edit->text('header', $this->names['header']);
			$this->create->fields()->edit->datetime('datepb', $this->names['datepb']);
			$this->create->validate([
				'work_header'	=> ['required', 'string', 'max:255'],
				'header'		=> ['required', 'string', 'max:255'],
				'datepb'		=> ['required', 'utc'],
			]);
			$this->create->text('title', 'Добавление изменений');
			$this->create->text('responseOk', 'Изменение добавлено');

			$this->update = new Update($this);
			$this->update->fields()->edit->select('state', $this->names['state'], $model->getStates());
			$this->update->fields()->edit->text('work_header', $this->names['work_header']);
			$this->update->fields()->edit->text('header', $this->names['header']);
			$this->update->fields()->edit->datetime('datepb', $this->names['datepb']);
			$this->update->validate([
				'state'		=> ['required', 'in:' . implode(',', array_keys($model->getStates()))],
				'work_header'	=> ['required', 'string', 'max:255'],
				'header'		=> ['required', 'string', 'max:255'],
				'datepb'		=> ['required', 'utc'],
			]);
			$this->update->text('title', 'Редактирование изменений');
			$this->update->text('responseOk', 'Изменения редактированы');

			$this->delete = new Delete($this);
			$this->delete->text('confirm', 'Удалить изменения?');
			$this->delete->text('responseOk', 'Изменения удалены');
		}

		/**
		 * Возвращает ссылки для управления
		 * @param array $item - Данные
		 * @return Accumulator
		 */
		private function getLinksManage(array $item): Accumulator {
			$links = new Accumulator();

			$id = isset($item['id']) ? (int)$item['id'] : 0;

			$links->push($this->linkUpdate->linkHrefID($id, $this->update->__('do'), $item));
			$links->push(linkRight('change_select')->linkHrefID($id, __('Перечень изменений'), ['changes' => $id]));
			$links->push($this->linkDoDelete->linkHrefID($id, $this->delete->__('do'), $item));

			return $links;
		}

	}