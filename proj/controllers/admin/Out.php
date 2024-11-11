<?php

	namespace Proj\Controllers\Admin;

	use AllowDynamicProperties;
	use Base\Access;
	use Base\Controller;
	use Base\Helper\Response;
	use Base\Model;
	use Base\Template\Buffer;
	use Base\View;
	use Proj\Collections;
	use proj\models\User;
	use Proj\Params\Site;
	use Proj\Templates\Admin\Template;
	use Proj\Links\Admin as Links;

	/**
	 * Работа с шаблоном
	 * @controller
	 * @property User $user
	 */
	#[AllowDynamicProperties] class Out extends Controller implements Collections\Out {
		use Buffer;

		public function __construct() {
			parent::__construct(self::ID);
		}

		/**
		 * Заполнение шапки
		 * @controllerMethod
		 * @return void
		 */
		public function setHead(): void {
			$this->user = Model::get('user');

			$data = [
				'user' => $this->user->getAlias(),
				'links' => [
					'logout' => Links\User::$exit->linkXHR('', [], ['class' => 'ico logout'])
				]
			];

			Template::$layout->header->push(
				View::get('admin.out.head', $data)
			);
		}

		/**
		 * Заполнение левого меню
		 * @controllerMethod
		 * @return void
		 */
		public function setMenu(): void {
			Template::$layout->menu->push(
				$this->item(Links\Page::$site->link(Links\Page::$site->address(), 'Открыть сайт', [], ['target' => '_blank'])),
				$this->separator(),

				$this->item(Links\Page::$home->linkHref('Главная'))
			);

			$menuDevelopment = [];
			if (Access::allow(Collections\DB::STRUCTURE, Collections\DB::ID)) $menuDevelopment['db'][] = Links\DB::$structure->linkHref('Структура');
			if (Access::allow(Collections\DB::CHECK, Collections\DB::ID)) $menuDevelopment['db'][] = Links\DB::$check->linkHref('Проверить');

			if ($menuDevelopment) {
				Template::$layout->menu->push($this->separator());
				Template::$layout->menu->push($this->head('Разработка'));

				if (isset($menuDevelopment['db'])) Template::$layout->menu->push(self::group('База данных', $menuDevelopment['db']));
			}
			//TODO Заполнить левое меню
		}

		/**
		 * Заполнение подвала
		 * @controllerMethod
		 * @return void
		 */
		public function setFooter(): void {
			$data = ['siteName' => Site::$siteName];

			Template::$layout->footer->push(View::get('admin.out.footer', $data));
		}

		/**
		 * Главная страница
		 * @controllerMethod
		 * @return void
		 */
		public function home(): void {
			Response::pushHistory(Links\Page::$home);
			Response::pushSection('content', View::get('admin.out.home'));
			Response::SendJSON();
		}

		/**
		 * Возвращает элемент меню
		 * @param $link - Ссылка
		 * @return string
		 */
		private function item($link): string {
			return "<li>{$link}</li>";
		}

		/**
		 * Возвращает группу меню
		 * @param string $title - Заголовок
		 * @param array $items - Элементы меню
		 * @return string
		 */
		private function group(string $title, array $items): string {
			self::start();
		?>
			<li>
				<span>
					<?= $title; ?>
					<ul>
						<?php foreach ($items as $item) { echo self::item($item); } ?>
					</ul>
				</span>
			</li>
		<?php
			return self::read();
		}

		/**
		 * Возвращает разделитель
		 * @return string
		 */
		private function separator(): string {
			return '<hr>';
		}

		/**
		 * Возвращает заголовок
		 * @param string $text - Текст заголовка
		 * @return string
		 */
		private function head(string $text): string {
			return "<div class = 'head'>{$text}</div>";
		}

	}