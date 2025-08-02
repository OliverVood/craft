<?php

	declare(strict_types=1);

	namespace Proj\Controllers\Admin;

	use Base\Controller;
	use Base\UI\View;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Editors;
	use Proj\Models;
	use Proj\UI\Templates\Admin\Template;

	/**
	 * Работа с шаблоном
	 * @controller
	 * @property Users $users
	 */
	class Out extends Controller {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * Заполнение шапки
		 * @controllerMethod
		 * @return void
		 */
		public function setHead(): void {
			/** @var Models\Users $users */ $users = model('users');

			$data = [
				'user' => $users->getAlias(),
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
			/** @var Template $template */ $template = template();

			$this->setMainToMenu($template);
			$this->setDevelopmentToMenu($template);
			$this->setAccessToMenu($template);
			$this->setSiteToMenu($template);
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

			/* Раздел Craft */
			if (linkRight('craft')->allow()) {
				$menu['craft'][] = linkRight('craft')->hyperlink(__('Описание'));
				$menu['craft'][] = linkRight('craft_help')->hyperlink(__('Помощь'));

				if (linkRight('craft_action')->allow()) {
					$menu['craft'][] = $this->separator();
					$menu['craft'][] = $this->group(__('Создать'), [
						linkRight('craft_action')->hyperlink(__('Признак'), ['entity' => 'feature', 'action' => 'create']),
						$this->separator(),
						linkRight('craft_action')->hyperlink(__('Контроллер'), ['entity' => 'controller', 'action' => 'create']),
						linkRight('craft_action')->hyperlink(__('Модель'), ['entity' => 'model', 'action' => 'create']),
						linkRight('craft_action')->hyperlink(__('Редактор'), ['entity' => 'editor', 'action' => 'create']),
						$this->separator(),
						linkRight('craft_action')->hyperlink(__('Отображение'), ['entity' => 'view', 'action' => 'create']),
						linkRight('craft_action')->hyperlink(__('Компонент'), ['entity' => 'component', 'action' => 'create']),
						$this->separator(),
						linkRight('craft_action')->hyperlink(__('Структуру'), ['entity' => 'structure', 'action' => 'create']),
					]);
				}
			}

			/* Раздел работы с базой данных */
			if (linkRight('dbs_check')->allow()) $menu['dbs'][] = linkRight('dbs_check')->hyperlink(__('Проверить'));
			if (linkRight('dbs_structure')->allow()) $menu['dbs'][] = linkRight('dbs_structure')->hyperlink(__('Структура'));

			/* Раздел статистики */
			if (linkRight('statistics_ips_select')->allow()) $menu['statistics'][] = linkRight('statistics_ips_select')->hyperlink(__('Запросы к серверу'), ['page' => 1]);
			if (linkRight('statistics_actions_select')->allow()) $menu['statistics'][] = linkRight('statistics_actions_select')->hyperlink(__('Действия клиента'), ['page' => 1]);

			if (!$menu) return;

			/* Построение меню */
			$template->layout->menu->push($this->separator());
			$template->layout->menu->push($this->head(__('Разработка')));

			if (isset($menu['craft'])) $template->layout->menu->push($this->group(__('Ремесло'), $menu['craft']));
			if (isset($menu['dbs'])) $template->layout->menu->push($this->group(__('База данных'), $menu['dbs']));
			if (isset($menu['statistics'])) $template->layout->menu->push($this->group(__('Статистика'), $menu['statistics']));
		}

		/**
		 * Построение меню раздела безопасности
		 * @param Template $template - Шаблон
		 * @return void
		 */
		private function setAccessToMenu(Template $template): void {
			$menu = [];

			/* Раздел пользовательских групп */
			if (linkRight('groups_select')->allow()) $menu['groups'][] = linkRight('groups_select')->hyperlink(__('Список групп'), ['page' => 1]);
			if (linkRight('groups_create')->allow()) $menu['groups'][] = linkRight('groups_create')->hyperlink(__('Добавить группу'));

			/* Раздел пользователей */
			if (linkRight('users_select')->allow()) $menu['users'][] = linkRight('users_select')->hyperlink(__('Список пользователей'), ['page' => 1]);
			if (linkRight('users_create')->allow()) $menu['users'][] = linkRight('users_create')->hyperlink(__('Добавить пользователя'));

			if (!$menu) return;

			/* Построение меню */
			$template->layout->menu->push($this->separator());
			$template->layout->menu->push($this->head(__('Безопасность')));
			if (isset($menu['groups'])) $template->layout->menu->push($this->group(__('Группы'), $menu['groups']));
			if (isset($menu['users'])) $template->layout->menu->push(self::group(__('Пользователи'), $menu['users']));
		}

		/**
		 * Построение меню сайта
		 * @param Template $template - Шаблон
		 * @return void
		 */
		private function setSiteToMenu(Template $template): void {
			$menu = [];

			/* Раздел новостей */
			if (linkRight('news_select')->allow()) $menu['news'][] =  linkRight('news_select')->hyperlink(__('Список новостей'), ['page' => 1]);
			if (linkRight('news_create')->allow()) $menu['news'][] = linkRight('news_create')->hyperlink(__('Добавить новость'));

			/* Раздел изменений */
			if (linkRight('changes_select')->allow()) $menu['changes'][] =  linkRight('changes_select')->hyperlink(__('Список изменений'), ['page' => 1]);
			if (linkRight('changes_create')->allow()) $menu['changes'][] = linkRight('changes_create')->hyperlink(__('Добавить изменения'));

			/* Раздел обратной связи */
			if (linkRight('feedback_select')->allow()) $menu['feedback'][] = linkRight('feedback_select')->hyperlink(__('Список'), ['page' => 1]);

			if (!$menu) return;

			/* Построение меню */
			$template->layout->menu->push($this->separator());
			$template->layout->menu->push($this->head(__('Сайт')));
			if (isset($menu['news'])) $template->layout->menu->push($this->group(__('Новости'), $menu['news']));
			if (isset($menu['changes'])) $template->layout->menu->push($this->group(__('Изменения'), $menu['changes']));
			if (isset($menu['feedback'])) $template->layout->menu->push($this->group(__('Обратная связь'), $menu['feedback']));
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