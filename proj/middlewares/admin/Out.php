<?php

	declare(strict_types=1);

	namespace Proj\Middlewares\Admin;

	use Base\Middleware;
	use Base\UI\Section;
	use Proj\Models;
	use Proj\UI\Templates\Admin;
    use stdClass;

	/**
	 * @middleware
	 * Вывод в шаблон
	 */
	class Out extends Middleware {

		/**
		 * Before
		 * @return bool
		 */
		public function inlet(): bool {
			return true;
		}

		/**
		 * After
		 * @return bool
		 */
		public function outlet(): bool {
			/** @var Admin $template */ $template = template();

			$this->setHead($template->layout->header);
			$this->setManager($template->layout->manager);
			$this->setMenu($template->layout->menu);
			$this->setFooter($template->layout->footer);

			template()->browse();

			return true;
		}

		/**
		 * Заполнение шапки
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setHead(Section $section): void {
			$section->push(
				view('admin.out.head')
			);
		}

		/**
		 * Заполнение секции управления
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setManager(Section $section): void {
			/** @var Models\Users $users */ $users = model('users');

			$user = $users->getCurrent();

			$section->push(view('admin.out.manager', compact('user')));
		}

		/**
		 * Заполнение левого меню
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setMenu(Section $section): void {
			$menu = new stdClass();

			$menu->items = [];

			$this->setMainToMenu($menu);
			$this->setDevelopmentToMenu($menu);
			$this->setAccessToMenu($menu);
			$this->setLocalizationToMenu($menu);
			$this->setSiteToMenu($menu);

			$section->push(view('admin.out.menu', compact('menu')));
		}

		/**
		 * Заполнение подвала
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setFooter(Section $section): void {
			$section->push(view('admin.out.footer'));
		}

		/**
		 * Построение меню: главный раздел
		 * @param stdClass $menu - меню
		 * @return void
		 */
		private function setMainToMenu(stdClass $menu): void {
			$menu->items[] = $this->link('external', 'site', __('Открыть сайт'), [], ['target' => '_blank']);
			$menu->items[] = $this->link('internal', 'home', __('Главная'), [], ['target' => '_blank']);
		}

		/**
		 * Построение меню: раздел разработчика
		 * @param stdClass $menu - меню
		 * @return void
		 */
		private function setDevelopmentToMenu(stdClass $menu): void {
			$items = [];

			/* Раздел Craft */
			if (allow('craft', 'select') || allow('craft', 'update')) {
				$items['craft'] = $this->group(__('Ремесло'), 'cr');

				if (allow('craft', 'select')) {
					$items['craft']->data->items[] = $this->link('right', 'craft_documentation', __('Документация'));
					$items['craft']->data->items[] = $this->link('right', 'craft_help', __('Помощь'));
				}

				if (allow('craft', 'update')) {
					$group = $this->group(__('Создать'), 'create');
					$group->data->items[] = $this->link('right', 'craft_action', __('Признак'), ['entity' => 'feature', 'action' => 'create']);
					$group->data->items[] = $this->separator();
					$group->data->items[] = $this->link('right', 'craft_action', __('Контроллер'), ['entity' => 'controller', 'action' => 'create']);
					$group->data->items[] = $this->link('right', 'craft_action', __('Модель'), ['entity' => 'model', 'action' => 'create']);
					$group->data->items[] = $this->link('right', 'craft_action', __('Редактор'), ['entity' => 'editor', 'action' => 'create']);
					$group->data->items[] = $this->separator();
					$group->data->items[] = $this->link('right', 'craft_action', __('Отображение'), ['entity' => 'view', 'action' => 'create']);
					$group->data->items[] = $this->link('right', 'craft_action', __('Компонент'), ['entity' => 'component', 'action' => 'create']);
					$group->data->items[] = $this->separator();
					$group->data->items[] = $this->link('right', 'craft_action', __('Структуру'), ['entity' => 'structure', 'action' => 'create']);

					$items['craft']->data->items[] = $group;
				}
			}

			/* Раздел работы с базой данных */
			if (linkRight('dbs_check')->allow() || linkRight('dbs_structure')->allow()) {
				$items['dbs'] = $this->group(__('База данных'), 'database');

				if (linkRight('dbs_check')->allow()) $items['dbs']->data->items[] = $this->link('right', 'dbs_check', __('Проверить'));
				if (linkRight('dbs_structure')->allow()) $items['dbs']->data->items[] = $this->link('right', 'dbs_structure', __('Структура'));
			}

			/* Раздел статистики */
			if (linkRight('statistics_ips_select')->allow() || linkRight('statistics_actions_select')->allow()) {
				$items['statistics'] = $this->group(__('Статистика'), 'statistic');

				if (linkRight('statistics_ips_select')->allow()) $items['statistics']->data->items[] = $this->link('right', 'statistics_ips_select', __('Запросы к серверу'), ['page' => 1]);
				if (linkRight('statistics_actions_select')->allow()) $items['statistics']->data->items[] = $this->link('right', 'statistics_actions_select', __('Действия клиента'), ['page' => 1]);
			}

			if (!$items) return;

			$block = $this->block(__('Разработка'));

			if (isset($items['craft'])) $block->data->items[] = $items['craft'];
			if (isset($items['dbs'])) $block->data->items[] = $items['dbs'];
			if (isset($items['statistics'])) $block->data->items[] = $items['statistics'];

			$menu->items[] = $block;
		}

		/**
		 * Построение меню: раздел безопасности
		 * @param stdClass $menu - меню
		 * @return void
		 */
		private function setAccessToMenu(stdClass $menu): void {
			$items = [];

			/* Раздел пользовательских групп */
			if (linkRight('groups_select')->allow() || linkRight('groups_create')->allow()) {
				$items['groups'] = $this->group(__('Группы'), 'groups');

				if (linkRight('groups_select')->allow()) $items['groups']->data->items[] = $this->link('right', 'groups_select', __('Список'), ['page' => 1]);
				if (linkRight('groups_create')->allow()) $items['groups']->data->items[] = $this->link('right', 'groups_create', __('Добавить'));
			}

			/* Раздел пользователей */
			if (linkRight('users_select')->allow() || linkRight('users_create')->allow()) {
				$items['users'] = $this->group(__('Пользователи'), 'users');

				if (linkRight('users_select')->allow()) $items['users']->data->items[] = $this->link('right', 'users_select', __('Список'), ['page' => 1]);
				if (linkRight('users_create')->allow()) $items['users']->data->items[] = $this->link('right', 'users_create', __('Добавить'));
			}

			if (!$items) return;

			$block = $this->block(__('Безопасность'));

			if (isset($items['groups'])) $block->data->items[] = $items['groups'];
			if (isset($items['users'])) $block->data->items[] = $items['users'];

			$menu->items[] = $block;
		}

		/**
		 * Построение меню: раздел локализации
		 * @param stdClass $menu - меню
		 * @return void
		 */
		private function setLocalizationToMenu(stdClass $menu): void {
			$items = [];

			$itemsLanguages = [];
			if (linkRight('languages_select')->allow()) $itemsLanguages[] = $this->link('right', 'languages_select', __('List'), ['page' => 1]);
			if (linkRight('languages_create')->allow()) $itemsLanguages[] = $this->link('right', 'languages_create', __('Add'));
			if ($itemsLanguages) {
				$items['languages'] = $this->group(__('Languages'), 'languages');
				$items['languages']->data->items = $itemsLanguages;
			}

			$itemsContexts = [];
			if (linkRight('contexts_select')->allow()) $itemsContexts[] = $this->link('right', 'contexts_select', __('List'), ['page' => 1]);
			if (linkRight('contexts_create')->allow()) $itemsContexts[] = $this->link('right', 'contexts_create', __('Add'));
			if ($itemsContexts) {
				$items['contexts'] = $this->group(__('Contexts'), 'contexts');
				$items['contexts']->data->items = $itemsContexts;
			}

			$itemsAliases = [];
			if (linkRight('aliases_select')->allow()) $itemsAliases[] = $this->link('right', 'aliases_select', __('List'), ['page' => 1]);
			if (linkRight('aliases_create')->allow()) $itemsAliases[] = $this->link('right', 'aliases_create', __('Add'));
			if ($itemsAliases) {
				$items['aliases'] = $this->group(__('Aliases'), 'aliases');
				$items['aliases']->data->items = $itemsAliases;
			}

			$itemsTranslations = [];
			if (linkRight('translations_select')->allow()) $itemsTranslations[] = $this->link('right', 'translations_select', __('List'), ['page' => 1]);
			if ($itemsTranslations) {
				$items['translations'] = $this->group(__('Translations'), 'translations');
				$items['translations']->data->items = $itemsTranslations;
			}

			if (!$items) return;

			$block = $this->block(__('Localization'));

			if (isset($items['languages'])) $block->data->items[] = $items['languages'];
			if (isset($items['contexts'])) $block->data->items[] = $items['contexts'];
			if (isset($items['aliases'])) $block->data->items[] = $items['aliases'];
			if (isset($items['translations'])) $block->data->items[] = $items['translations'];

			$menu->items[] = $block;
		}

		/**
		 * Построение меню: Раздел сайта
		 * @param stdClass $menu - меню
		 * @return void
		 */
		private function setSiteToMenu(stdClass $menu): void {
			$items = [];

			/* Раздел новостей */
			if (linkRight('news_select')->allow() || linkRight('news_create')->allow()) {
				$items['news'] = $this->group(__('Новости'), 'news');

				if (linkRight('news_select')->allow()) $items['news']->data->items[] = $this->link('right', 'news_select', __('Список'), ['page' => 1]);
				if (linkRight('news_create')->allow()) $items['news']->data->items[] = $this->link('right', 'news_create', __('Добавить'));
			}

			/* Раздел изменений */
			if (linkRight('changes_select')->allow() || linkRight('changes_create')->allow()) {
				$items['changes'] = $this->group(__('Изменения'), 'changes');

				if (linkRight('changes_select')->allow()) $items['changes']->data->items[] = $this->link('right', 'changes_select', __('Список'), ['page' => 1]);
				if (linkRight('changes_create')->allow()) $items['changes']->data->items[] = $this->link('right', 'changes_create', __('Добавить'));
			}

			/* Раздел обратной связи */
			if (linkRight('feedback_select')->allow()) {
				$items['feedback'] = $this->group(__('Обратная связь'), 'feedback');

				if (linkRight('feedback_select')->allow()) $items['feedback']->data->items[] = $this->link('right', 'feedback_select', __('Список'), ['page' => 1]);
			}

			if (!$items) return;

			$block = $this->block(__('Сайт'));

			if (isset($items['news'])) $block->data->items[] = $items['news'];
			if (isset($items['changes'])) $block->data->items[] = $items['changes'];
			if (isset($items['feedback'])) $block->data->items[] = $items['feedback'];

			$menu->items[] = $block;
		}

		/**
		 * Возвращает блок меню
		 * @param string $head - Заголовок блока
		 * @return stdClass
		 */
		private function block(string $head): stdClass {
			$data = new stdClass();
			$data->head = $head;
			$data->items = [];

			return $this->get('block', $data);
		}

		/**
		 * Возвращает группу меню
		 * @param string $head - Заголовок группы
		 * @param string $icon - Класс иконки
		 * @return stdClass
		 */
		private function group(string $head, string $icon = ''): stdClass {
			$data = new stdClass();
			$data->head = $head;
			$data->icon = $icon;
			$data->items = [];

			return $this->get('group', $data);
		}

		/**
		 * Возвращает ссылку меню
		 * @param string $type - Тип ссылки
		 * @param string $name - Псевдоним ссылки
		 * @param string $text - Текст ссылки
		 * @param array $data - Данные
		 * @param array $params - Параметры
		 * @return stdClass
		 */
		private function link(string $type, string $name, string $text, array $data = [], array $params = []): stdClass {
			$link = new stdClass();
			$link->type = $type;
			$link->name = $name;
			$link->text = $text;
			$link->data = $data;
			$link->params = $params;

			return $this->get('link', $link);
		}

		/**
		 * Возвращает разделитель меню
		 * @return stdClass
		 */
		private function separator(): stdClass {
			return $this->get('separator');
		}

		/**
		 * Возвращает элемент меню
		 * @param string $type - Тип
		 * @param stdClass $data - Данные
		 * @return stdClass
		 */
		private function get(string $type, stdClass $data = new stdClass()): stdClass {
			$r = new stdClass;
			$r->type = $type;
			$r->data = $data;
			return $r;
		}

	}
