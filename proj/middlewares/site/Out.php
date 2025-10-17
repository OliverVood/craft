<?php

	declare(strict_types=1);

	namespace Proj\Middlewares\Site;

	use Base\Middleware;
	use Base\UI\Section;
	use Proj\UI\Templates\Site\Template;

	/**
	 * Вывод в шаблон
	 */
	class Out extends Middleware {

		/**
		 * @return void
		 */
		public function inlet(): void {  }

		/**
		 * Выводит шапку и подвал
		 * @return void
		 */
		public function outlet(): void {
			/** @var Template $template */ $template = template();

			$this->setHead($template->layout->header);
			$this->setFooter($template->layout->footer);

			template()->browse();
		}

		/**
		 * Заполнение шапки
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setHead(Section $section): void {
			$section->push(
				view('site.out.header')
			);
		}

		/**
		 * Заполнение подвала
		 * @param Section $section - Секция
		 * @return void
		 */
		private function setFooter(Section $section): void {
			$section->push(
				view('site.out.footer')
			);
		}

	}
