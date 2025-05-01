<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions;

	use Base\Data\Set;
	use Base\Editor\Actions\Traits\Entree;
	use base\editor\actions\traits\Texts;
	use Base\Editor\Actions\Traits\Validation;
	use Base\Editor\Controller;
	use Base\Editor\Model;
	use Base\Helper\Accumulator;
	use Closure;
	use JetBrains\PhpStorm\NoReturn;

	/**
	 * Контроллер-редактор прав
	 */
	class Access {
		use Entree;
		use Texts;
		use Validation;

		private Controller $controller;

		public Closure $fnGetLinksNavigate;

		private string $tpl = 'admin.editor.access';

		/**
		 * @param Controller $controller - Контроллер
		 */
		public function __construct(Controller $controller) {
			$this->controller = $controller;

			$this->access = 'access';

			$this->fnGetLinksNavigate = fn () => $this->getLinksNavigate();

			$this->text('title', 'Права доступа');
			$this->text('do', 'Установить права доступа');
			$this->text('btn', 'Изменить');
			$this->text('responseErrorAccess', 'Не достаточно прав');
			$this->text('responseErrorNotFound', 'Элемент не найден');
			$this->text('responseErrorValidate', 'Ошибка валидации данных');
			$this->text('responseOkSet', 'Права доступа установлены');
		}

		/**
		 * Возвращает блок доступа
		 * @param Set $data - Пользовательские данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		#[NoReturn] public function get(Set $data, int $id): void {
			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$title = $this->__('title') . " #{$id}";
			$features = app()->features;
			$items = [];
			foreach ($model->access($id, ['feature', 'right', 'permission'])->each() as $item) {
				$items[$item['feature']][$item['right']] = $item['permission'];
			}
			$action = $this->controller->linkDoAccess;
			$textBtn = $this->__('btn');
			$editor = $this->controller;

			response()->history($this->controller->linkAccess, ['id' => $id]);
			response()->section('content', view($this->tpl, compact('id', 'title', 'features', 'items', 'action', 'textBtn', 'editor')));
			response()->ok();
		}

		/**
		 * Устанавливает доступ
		 * @param Set $data - Пользовательские данные
		 * @param int $id - Идентификатор
		 * @return void
		 */
		#[NoReturn] public function set(Set $data, int $id): void {
			$rights = request()->data()->inputArray('rights')->data([]);

			if (!$this->allow($id)) response()->forbidden($this->__('responseErrorAccess'));

			/** @var Model $model */ $model = $this->controller->model();

			$errors = [];
			if (!$this->validation(['id' => $id], $errors)) response()->unprocessableEntity($this->__('responseErrorValidate'), $errors);

			$model->setAccess($id, $rights);

			response()->ok(null, $this->__('responseOkSet'));
		}

		/**
		 * Возвращает ссылки навигации
		 * @return Accumulator
		 */
		public function getLinksNavigate(): Accumulator {
			$links = new Accumulator();

			if ($this->controller->linkSelect->allow()) $links->push($this->controller->linkSelect->hyperlink('<< ' . $this->controller->select->__('title'), ['page' => old('page')->int(1)]));

			return $links;
		}

	}