<?php

	namespace Base\UI;

	/**
	 * Агрегатор CSS файлов
	 */
	class CSS {
		private array $stylesheets = [];

		/**
		 * Добавляет CSS
		 * @param string $href - Путь к CSS файлу
		 * @param string|null $version - Версия
		 * @return void
		 */
		public function add(string $href, ?string $version = null): void{
			if (in_array($href, $this->stylesheets)) die("Stylesheets «{$href}» is already in use");

			if ($version) $href = $this->appendVersion($href, $version);

			$this->stylesheets[] = $href;
		}

		/**
		 * Добавляет версию к CSS файлу
		 * @param string $href - Путь к CSS файлу
		 * @param string|null $version - Версия
		 * @return string
		 */
		public function appendVersion(string $href, ?string $version): string {
			$matches = [];
			preg_match('/^(.*)\.css$/', $href, $matches);
			$path = $matches['1'];
			return "{$path}.{$version}.css";
		}

		/**
		 * Выводит CSS файлы
		 * @return void
		 */
		public function browse(): void {
			foreach ($this->stylesheets as $url) { ?><link rel = "stylesheet" href = "<?= $url; ?>" type = "text/css"><?php }
		}

	}