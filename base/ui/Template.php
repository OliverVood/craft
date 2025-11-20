<?php

	namespace Base\UI;

	/**
	 * Базовый класс для работы с шаблонами
	 */
	abstract class Template {
		public Layout $layout;

		protected string $view;

		public CSS $css;
		public JS $js;
		public SEO $seo;
		private string $favicon = '';

		public function __construct() {
			$this->seo = new SEO();
			$this->css = new CSS();
			$this->js = new JS();
		}

		/**
		 * Выводит шаблон
		 * @param bool $stop - Остановить ли дальнейшее выполнение
		 * @return void
		 */
		public function browse(bool $stop = false): void {
			echo view($this->view);
			if ($stop) die();
		}

		/**
		 * Выводит содержимое Head
		 * @return void
		 */
		public function browseHead(): void {
			$this->js->browse();
			$this->css->browse();
			$this->seo->browse();
			if ($this->favicon) { ?><link rel = "icon" href = "<?= $this->favicon; ?>" type = "image/x-icon"><?php };
		}

		/**
		 * Устанавливает / возвращает картинку ресурса
		 * @param string $favicon
		 * @return ?string
		 */
		public function favicon(string $favicon = ''): ?string {
			if ($favicon) {
				$this->favicon = $favicon;
				return null;
			}

			return $this->favicon;
		}

	}