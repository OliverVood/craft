<?php

	declare(strict_types=1);

	namespace Proj\Editors\Controllers\Site;

	use Base\Editor\Actions\Browse;
	use Base\Editor\Actions\Create;
	use Base\Editor\Actions\Delete;
	use Base\Editor\Actions\Select;
	use Base\Editor\Actions\Update;
	use Base\Editor\Controller;
	use Proj\Editors\Models\Site\News as Model;

	/**
	 * Контроллер-редактор новостей
	 * @controller
	 */
	class News extends Controller {
		public function __construct() {
			parent::__construct(app()->features('news'), 'site.news');

			/** @var Model $model */ $model = $this->model();

			$this->select = new Select($this);
			$this->select->fields()->browse->text('id', '#');
			$this->select->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->select->fields()->browse->datetime('datepb', __('Дата публикации'), 'd.m.Y H:i');
			$this->select->fields()->browse->text('header', __('Заголовок'));
			$this->select->text('title', 'Список новостей');

			$this->browse = new Browse($this);
			$this->browse->fields()->browse->fromArray('state', __('Состояние'), $model->getStates());
			$this->browse->fields()->browse->text('header', __('Заголовок'));
			$this->browse->fields()->browse->text('content', __('Текст'));
			$this->browse->fields()->browse->datetime('datepb', __('Дата публикации'), 'd.m.Y H:i');
			$this->browse->text('title', 'Просмотр новости');

			$this->create = new Create($this);
			$this->create->fields()->edit->text('header', __('Заголовок'));
			$this->create->fields()->edit->textarea('content', __('Текст'));
			$this->create->fields()->edit->file('cover', __('Обложка'), __('Выберите обложку'), '.jpg, .jpeg, .png');
			$this->create->fields()->edit->datetime('datepb', __('Дата публикации'));
			$this->create->validate([
				'header'	=> ['required', 'string', 'max:255'],
				'content'	=> ['required', 'string'],
				'datepb'	=> ['required', 'utc'],
			]);
			$this->create->text('title', 'Добавление новости');
			$this->create->text('responseOk', 'Новость добавлена');

			$this->update = new Update($this);
			$this->update->fields()->edit->hidden('id');
			$this->update->fields()->edit->select('state', __('Состояние'), $model->getStates());
			$this->update->fields()->edit->text('header', __('Заголовок'));
			$this->update->fields()->edit->textarea('content', __('Текст'));
			$this->update->fields()->edit->file('cover', 'Обложка', 'Выберите обложку', '.jpg, .jpeg, .png');
			$this->update->fields()->edit->datetime('datepb', __('Дата публикации'));
			$this->update->validate([
				'state'		=> ['required', 'in:' . implode(',', array_keys($model->getStates()))],
				'header'	=> ['required', 'string', 'max:255'],
				'content'	=> ['required', 'string'],
				'datepb'	=> ['required', 'utc'],
			]);
			$this->update->text('title', 'Редактирование новости');
			$this->update->text('responseOk', 'Новость изменена');

			$this->delete = new Delete($this);
			$this->delete->text('confirm', 'Удалить новость?');
			$this->delete->text('responseOk', 'Новость удалена');
		}

	}