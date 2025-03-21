<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use AllowDynamicProperties;
	use Base\Controller;
	use Base\UI\View;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Editors;
	use Proj\Editors\Controllers as EditorsControllers;
	use Proj\Models\Users;
	use Proj\UI\Templates\Admin\Template;

	/**
	 * Работа с шаблоном
	 * @controller
	 * @property Users $users
	 */
	#[AllowDynamicProperties] class Out extends Controller {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * Заполнение шапки
		 * @controllerMethod
		 * @return void
		 */
		public function setHead(): void {
			$this->users = model('users');

			$data = [
				'user' => $this->users->getAlias(),
				'links' => [
					'logout' => linkInternal('users_exit'),
				],
			];

			/** @var Template $template */ $template = template();

			$template->layout->header->push(
				view('admin.out.head', $data)
			);
		}

		/**
		 * Заполнение левого меню
		 * @controllerMethod
		 * @return void
		 */
		public function setMenu(): void {
			/** @var Template $template */$template = template();

			$this->setMainToMenu($template);
			$this->setDevelopmentToMenu($template);
			$this->setAccessToMenu($template);
		}

		/**
		 * Построение меню главного раздела
		 * @param Template $template - Шаблон
		 * @return void
		 */
		private function setMainToMenu(Template $template): void {
			$template->layout->menu->push(
				linkExternal('site')->hyperlink(__('Открыть сайт'), [], ['target' => '_blank']),
				$this->separator(),
				linkInternal('home')->hyperlink(__('Главная'))
			);
		}

		/**
		 * Построение меню раздела разработчика
		 * @param Template $template - Шаблон
		 * @return void
		 */
		private function setDevelopmentToMenu(Template $template): void {
			$menu = [];

			/* Раздел работы с базой данных */
			if (linkRight('dbs_check')->allow()) $menu['dbs'][] = linkRight('dbs_check')->hyperlink(__('Проверить'));
			if (linkRight('dbs_structure')->allow()) $menu['dbs'][] = linkRight('dbs_structure')->hyperlink(__('Структура'));

//			/* Раздел интерфейса Craft */
////			$menuComposition = Composition::instance()->GetMenu();//TODO Заполнить левое меню
//
//			/* Раздел статистики */
			if (linkRight('statistics_ips_select')->allow()) $menu['statistics'][] = linkRight('statistics_ips_select')->hyperlink(__('Запросы к серверу'), ['page' => 1]);
			if (linkRight('statistics_actions_select')->allow()) $menu['statistics'][] = linkRight('statistics_actions_select')->hyperlink(__('Действия клиента'), ['page' => 1]);

			if (!$menu) return;

			/* Построение меню */
			$template->layout->menu->push($this->separator());
			$template->layout->menu->push($this->head(__('Разработка')));

			if (isset($menu['dbs'])) $template->layout->menu->push($this->group(__('База данных'), $menu['dbs']));
//			// Композиция
			if (isset($menu['statistics'])) $template->layout->menu->push($this->group(__('Статистика'), $menu['statistics']));
		}

		/**
		 * Построение меню раздела безопасности
		 * @param Template $template - Шаблон
		 * @return void
		 */
		private function setAccessToMenu(Template $template): void {
			$menu = [];

//			/* Раздел пользовательских групп */
			if (linkRight('groups_select')->allow()) $menu['groups'][] = linkRight('groups_select')->hyperlink(__('Список групп'), ['page' => 1]);
			if (linkRight('groups_create')->allow()) $menu['groups'][] = linkRight('groups_create')->hyperlink(__('Добавить группу'));
//
//			/* Раздел пользователей */
//			/** @var EditorsControllers\User\User $editorUser */ $editorUser = controllerEditor('user.user');
//			if ($editorUser->select->allow()) $menu['users'][] = $editorUser->select->hyperlink(__('Список пользователей'), ['page' => 1]);
//			if ($editorUser->create->allow()) $menu['users'][] = $editorUser->create->linkHref(__('Добавить пользователя'));

			if (!$menu) return;

//			/* Построение меню */
//			Template::$layout->menu->push($this->separator());
//			Template::$layout->menu->push($this->head(__('Безопасность')));
//
			if (isset($menu['groups'])) $template->layout->menu->push($this->group(__('Группы'), $menu['groups']));
//			if (isset($menu['users'])) Template::$layout->menu->push(self::group(__('Пользователи'), $menu['users']));
		}

		private function setSiteToMenu(): void {//TODO Заполнить левое меню
//			$menuNews = News::instance()->GetMenu();
//			$menuChanges = Changes::instance()->GetMenu();
//			$menuFeedback = Feedback::instance()->GetMenu();
//			if ($menuNews || $menuChanges) {
//				Layout::instance()->menu->Push($this->OutMenuSeparator());
//				Layout::instance()->menu->Push($this->OutMenuHead('Сайт'));
//				if ($menuNews) Layout::instance()->menu->Push(TPL\Group::ToVar('Новости', $menuNews));
//				if ($menuChanges) Layout::instance()->menu->Push(TPL\Group::ToVar('Актуальное', $menuChanges));
//				if ($menuFeedback) Layout::instance()->menu->Push(TPL\Group::ToVar('Обратная связь', $menuFeedback));
//			}
		}

		/**
		 * Заполнение подвала
		 * @controllerMethod
		 * @return void
		 */
		public function setFooter(): void {
			/** @var Template $template */$template = template();

			$data = ['siteName' => app()->params->name];

			$template->layout->footer->push(View::get('admin.out.footer', $data));
		}

		/**
		 * Главная страница
		 * @controllerMethod
		 * @return void
		 */
		#[NoReturn] public function home(): void {
			response()->history(linkInternal('home'));
			response()->section('content', view('admin.out.home'));
			response()->ok();
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
			buffer()->start();
		?>
			<li>
				<span>
					<?= $title; ?>
					<ul>
						<?php foreach ($items as $item) { echo $this->item($item); } ?>
					</ul>
				</span>
			</li>
		<?php
			return buffer()->read();
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