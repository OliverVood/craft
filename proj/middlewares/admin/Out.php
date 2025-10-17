<?php

	declare(strict_types=1);

	namespace Proj\Middlewares\Admin;

	use Base\Middleware;
	use Base\UI\Section;
	use Proj\UI\Templates\Admin\Template;
	use Proj\Models;

	/**
	 * Вывод в шаблон
	 */
	class Out extends Middleware {

		/**
		 * Before
		 * @return void
		 */
		public function inlet(): void {  }

		/**
		 * After
		 * @return void
		 */
		public function outlet(): void {
			/** @var Template $template */ $template = template();

			$this->setHead($template->layout->header);
			$this->setMenu($template->layout->menu);
			$this->setFooter($template->layout->footer);

			template()->browse();
		}

		/**
		 * Заполнение шапки
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setHead(Section $section): void {
			/** @var Models\Users $users */ $users = model('users');

			$data = [
				'user' => $users->getAlias(),
				'links' => [
					'logout' => linkInternal('users_exit'),
				],
			];

			$section->push(
				view('admin.out.head', $data)
			);
		}

		/**
		 * Заполнение подвала
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setFooter(Section $section): void {
			$data = ['siteName' => app()->params->name];

			$section->push(view('admin.out.footer', $data));
		}

		/**
		 * Заполнение левого меню
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setMenu(Section $section): void {
			$this->setMainToMenu($section);
			$this->setDevelopmentToMenu($section);
			$this->setAccessToMenu($section);
			$this->setSiteToMenu($section);
		}

		/**
		 * Построение меню главного раздела
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setMainToMenu(Section $section): void {
			$section->push(
				linkExternal('site')->hyperlink(__('Открыть сайт'), [], ['target' => '_blank']),
				$this->separator(),
				linkInternal('home')->hyperlink(__('Главная'))
			);
		}

		/**
		 * Построение меню раздела разработчика
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setDevelopmentToMenu(Section $section): void {
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
			$section->push($this->separator());
			$section->push($this->head(__('Разработка')));

			if (isset($menu['craft'])) $section->push($this->group(__('Ремесло'), $menu['craft']));
			if (isset($menu['dbs'])) $section->push($this->group(__('База данных'), $menu['dbs']));
			if (isset($menu['statistics'])) $section->push($this->group(__('Статистика'), $menu['statistics']));
		}

		/**
		 * Построение меню раздела безопасности
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setAccessToMenu(Section $section): void {
			$menu = [];

			/* Раздел пользовательских групп */
			if (linkRight('groups_select')->allow()) $menu['groups'][] = linkRight('groups_select')->hyperlink(__('Список групп'), ['page' => 1]);
			if (linkRight('groups_create')->allow()) $menu['groups'][] = linkRight('groups_create')->hyperlink(__('Добавить группу'));

			/* Раздел пользователей */
			if (linkRight('users_select')->allow()) $menu['users'][] = linkRight('users_select')->hyperlink(__('Список пользователей'), ['page' => 1]);
			if (linkRight('users_create')->allow()) $menu['users'][] = linkRight('users_create')->hyperlink(__('Добавить пользователя'));

			if (!$menu) return;

			/* Построение меню */
			$section->push($this->separator());
			$section->push($this->head(__('Безопасность')));
			if (isset($menu['groups'])) $section->push($this->group(__('Группы'), $menu['groups']));
			if (isset($menu['users'])) $section->push(self::group(__('Пользователи'), $menu['users']));
		}

		/**
		 * Построение меню сайта
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setSiteToMenu(Section $section): void {
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
			$section->push($this->separator());
			$section->push($this->head(__('Сайт')));
			if (isset($menu['news'])) $section->push($this->group(__('Новости'), $menu['news']));
			if (isset($menu['changes'])) $section->push($this->group(__('Изменения'), $menu['changes']));
			if (isset($menu['feedback'])) $section->push($this->group(__('Обратная связь'), $menu['feedback']));
		}

		/**
		 * Возвращает заголовок
		 * @param string $text - Текст заголовка
		 * @return string
		 */
		private function head(string $text): string {
			return "<div class = 'head'>{$text}</div>";
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

	}
