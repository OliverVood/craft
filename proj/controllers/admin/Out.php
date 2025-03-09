<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use AllowDynamicProperties;
	use Base\Access;
	use Base\Controller;
	use Base\Helper\Response;
	use Base\View;
	use Proj\Access\Admin as Rights;
	use Proj\Collections;
	use Proj\Editors;
	use Proj\Links\Admin as Links;
	use proj\models\Users;
	use Proj\Params\Site;
	use Proj\Templates\Admin\Template;
	use Proj\Editors\Controllers as EditorsControllers;

	/**
	 * Работа с шаблоном
	 * @controller
	 * @property Users $users
	 */
	#[AllowDynamicProperties] class Out extends Controller {

		public function __construct() {
			parent::__construct(app()->features('out')->id());
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
					'logout' => linkInternal('users_exit')->linkXHR('', [], ['class' => 'ico logout']),
				],
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
			$this->setMainToMenu();
			$this->setDevelopmentToMenu();
			$this->setAccessToMenu();
		}

		/**
		 * Построение меню главного раздела
		 * @return void
		 */
		private function setMainToMenu(): void {
			Template::$layout->menu->push(
				$this->item(Links\Page::$site->link(Links\Page::$site->address(), __('Открыть сайт'), [], ['target' => '_blank'])),
				$this->separator(),

				$this->item(Links\Page::$home->linkHref(__('Главная')))
			);
		}

		/**
		 * Построение меню раздела разработчика
		 * @return void
		 */
		private function setDevelopmentToMenu(): void {
			$menu = [];

			/* Раздел работы с базой данных */
			if (Access::allow(Rights\DB::ACCESS_DB_STRUCTURE, Collections\DB::ID)) $menu['db'][] = Links\DB::$structure->linkHref(__('Структура'));
			if (Access::allow(Rights\DB::ACCESS_DB_CHECK, Collections\DB::ID)) $menu['db'][] = Links\DB::$check->linkHref(__('Проверить'));

			/* Раздел интерфейса Craft */
//			$menuComposition = Composition::instance()->GetMenu();//TODO Заполнить левое меню

			/* Раздел статистики */
			/** @var EditorsControllers\Statistic\IP $editorIP */ $editorIP = controllerEditor('statistic.ip');
			if ($editorIP->select->allow()) $menu['statistic'][] = $editorIP->select->linkHref(__('Запросы к серверу'), ['page' => 1]);
			/** @var EditorsControllers\Statistic\Action $editorAction */ $editorAction = controllerEditor('statistic.action');
			if ($editorAction->select->allow()) $menu['statistic'][] = $editorAction->select->linkHref(__('Действия клиента'), ['page' => 1]);

			if (!$menu) return;

			/* Построение меню */
			Template::$layout->menu->push($this->separator());
			Template::$layout->menu->push($this->head(__('Разработка')));

			if (isset($menu['db'])) Template::$layout->menu->push(self::group(__('База данных'), $menu['db']));
			// Композиция
			if (isset($menu['statistic'])) Template::$layout->menu->push(self::group(__('Статистика'), $menu['statistic']));
		}

		/**
		 * Построение меню раздела безопасности
		 * @return void
		 */
		private function setAccessToMenu(): void {
			$menu = [];

			/* Раздел пользовательских групп */
			/** @var EditorsControllers\User\Group $editorGroup */ $editorGroup = controllerEditor('user.group');
			if ($editorGroup->select->allow()) $menu['groups'][] = $editorGroup->select->linkHref(__('Список групп'), ['page' => 1]);
			if ($editorGroup->create->allow()) $menu['groups'][] = $editorGroup->create->linkHref(__('Добавить группу'));

			/* Раздел пользователей */
			/** @var EditorsControllers\User\User $editorUser */ $editorUser = controllerEditor('user.user');
			if ($editorUser->select->allow()) $menu['users'][] = $editorUser->select->linkHref(__('Список пользователей'), ['page' => 1]);
			if ($editorUser->create->allow()) $menu['users'][] = $editorUser->create->linkHref(__('Добавить пользователя'));

			if (!$menu) return;

			/* Построение меню */
			Template::$layout->menu->push($this->separator());
			Template::$layout->menu->push($this->head(__('Безопасность')));

			if (isset($menu['groups'])) Template::$layout->menu->push(self::group(__('Группы'), $menu['groups']));
			if (isset($menu['users'])) Template::$layout->menu->push(self::group(__('Пользователи'), $menu['users']));
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