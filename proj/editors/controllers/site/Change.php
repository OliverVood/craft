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
	use Proj\Editors\Models\Site\Change as Model;

	/**
	 * Контроллер-редактор изменения
	 */
	class Change extends Controller {
		public function __construct() {
			parent::__construct(app()->features('changes'), 'site.change');

			$this->params->changes = request()->data()->defined('changes')->int(0);

			/** @var Model $model */ $model = $this->model();

			$this->select = new Select($this);
			$this->select->fnGetLinksNavigate = fn () => $this->getLinksNavigateSelect();
			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->select->fields()->browse->text('header', __('Заголовок'));
			$this->select->text('title', 'Список конкретных изменений');

			$this->browse = new Browse($this);
			$this->browse->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->browse->fields()->browse->text('header', __('Заголовок'));
			$this->browse->fields()->browse->text('content', __('Текст'));
			$this->browse->text('title', 'Просмотр изменения');

			$this->create = new Create($this);
			$this->create->fnPrepareView = fn (array & $item) => $this->prepareViewCreate($item);
			$this->create->fields()->edit->hidden('cid');
			$this->create->fields()->edit->text('header', __('Заголовок'));
			$this->create->fields()->edit->textarea('content', __('Текст'));
			$this->create->fields()->edit->file('cover', __('Обложка'), __('Выберите обложку'), '.jpg, .jpeg, .png');
			$this->create->validate([
				'cid' => ['required', 'int', 'foreign:craft,changes,id'],
				'header'	=> ['required', 'string', 'max:255'],
				'content'	=> ['required', 'string'],
			]);
			$this->create->text('title', 'Добавление изменения');
			$this->create->text('do', 'Добавить изменение');
			$this->create->text('responseOk', 'Изменение добавлено');

			$this->update = new Update($this);
//					'state'			=> new Edit\Select('Состояние', 'form[state]', [
//						Consts\Changes::STATE_DRAFT	=> 'Черновик',
//						Consts\Changes::STATE_ACTIVE	=> 'Активный',
//						Consts\Changes::STATE_INACTIVE	=> 'Не активный',
//					]),
//					'header'		=> new Edit\Text('Заголовок', 'form[header]'),
//					'content'		=> new Edit\TextArea('Текст', 'form[content]'),
//					'cover'			=> new Edit\File('Обложка', 'form[cover]', 'Выберите обложку', '.jpg, .jpeg, .png')
//				];
//			$this->titleUpdate = 'Редактировать актуальное';
//			$this->titleDoUpdate = 'Актуальное изменено';

			$this->delete = new Delete($this);
//			$this->titleDelete = 'Удалить актуальное?';
//			$this->titleDoDelete = 'Актуальное удалено';
//
//			protected function RegActionSelect(): void { $this->select = new ActionRight($this->id, $this->name, 'select', "/{$this->name}/select?cid=%cid%&page=%page%", /* @lang JavaScript */"Base.Common.Query.SendData('/{$this->name}/select', {cid: %cid%, page: %page%}); return false;"); }
//			protected function RegActionCreate(): void { $this->create = new ActionRight($this->id, $this->name, 'create', "/{$this->name}/create?cid=%cid%", /* @lang JavaScript */"Base.Common.Query.SendData('/{$this->name}/create', {cid: %cid%}); return false;"); }
//			protected function RegActionUpdate(): void { $this->update = new ActionRight($this->id, $this->name, 'update', "/{$this->name}/update?id=%id%&cid=%cid%", /* @lang JavaScript */"Base.Common.Query.SendData('/{$this->name}/update', {id: %id%, cid: %cid%}); return false;"); }
//			protected function RegActionDoDelete(): void { $this->do_delete = new ActionRight($this->id, $this->name, 'do_delete', "/{$this->name}/do_delete?id=%id%&cid=%cid%", /* @lang JavaScript */ "if (confirm('{$this->titleDelete}')) Base.Common.Query.SendData('/{$this->name}/do_delete', {id: %id%, cid: %cid%}); return false;"); }
		}

		/**
		 * Регистрация ссылок
		 * @return void
		 */
		protected function links(): void {
			$this->linkAccess = linkRight('change_access', false);
			$this->linkSelect = linkRight('change_select', false);
			$this->linkBrowse = linkRight('change_browse', false);
			$this->linkCreate = linkRight('change_create', false);
			$this->linkUpdate = linkRight('change_update', false);

			$this->linkDoAccess = linkRight('change_do_access', false);
			$this->linkDoCreate = linkRight('change_do_create', false);
			$this->linkDoUpdate = linkRight('change_do_update', false);
			$this->linkDoDelete = linkRight('change_do_delete', false);
			$this->linkSetState = linkRight('change_set_state', false);
		}

		/**
		 * Возвращает ссылки навигации
		 * @return Accumulator
		 */
		public function getLinksNavigateSelect(): Accumulator {
			$links = new Accumulator();

			if ($this->allow('select')) $links->push(linkInternal('changes_select')->hyperlink('<< ' . __('Изменения'), array_merge(['page' => old('page')->int(1)], (array)$this->params)));
			if ($this->allow('create')) $links->push($this->linkCreate->linkHrefID($this->params->changes, $this->create->__('do'), (array)$this->params));

			return $links;
		}

		/**
		 * Подготовка данных для блока создания
		 * @param array $item - Данные
		 * @return void
		 */
		private function prepareViewCreate(array & $item): void {
			$item['cid'] = $this->params->changes;
		}

	}