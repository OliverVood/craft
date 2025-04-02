<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Actions\Traits\Entree;
	use base\editor\actions\traits\Texts;
	use Base\Editor\Controller;
	use Base\Editor\Model;
	use JetBrains\PhpStorm\NoReturn;

	class Access {
		use Entree;
		use Texts;

		private Controller $controller;

		private string $tpl = 'admin.editor.access';

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'access';

			$this->text('title', 'Права доступа');
			$this->text('btn', 'Изменить');
			$this->text('responseErrorAccess', 'Не достаточно прав');
			$this->text('responseOkSet', 'Права доступа установлены');
		}

		/**
		 * Возвращает блок доступа
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function get(Set $data): void {
			$id = $data->defined('id')->int(0);

			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$title = $this->__('title') . " #{$id}";
			$features = app()->features;
			$items = [];
			foreach ($model->access($id, ['feature', 'right', 'permission'])->each() as $item) {
				$items[$item['feature']][$item['right']] = $item['permission'];
			}
			$action = $this->controller->do_access;
			$textBtn = $this->__('btn');
			$editor = $this->controller;

			response()->history($this->controller->access, ['id' => $id]);
			response()->section('content', view($this->tpl, compact('id', 'title', 'features', 'items', 'action', 'textBtn', 'editor')));
			response()->ok();
		}

		/**
		 * Устанавливает доступ
		 * @param Set $data - Пользовательские данные
		 * @return void
		 */
		#[NoReturn] public function set(Set $data): void {
			$id = $data->defined('id')->int(0);
			$rights = $data->defined('rights')->data([]);

			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();
			$model->setAccess($id, $rights);

			response()->ok(null, $this->__('responseOkSet'));
		}

	}