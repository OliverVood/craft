<?php

	namespace Base\Template;

	/**
	 * Агрегатор JS файлов
	 */
	class JS {
		private array $scripts = [];

		/**
		 * Добавляет JS
		 * @param string $src - Путь к JS файлу
		 * @param string|null $version - Версия
		 * @return void
		 */
		public function add(string $src, ?string $version = null): void{
			if (in_array($src, $this->scripts)) die("Script «{$src}» is already in use");

			if ($version) $src = $this->appendVersion($src, $version);

			$this->scripts[] = $src;
		}

		/**
		 * Добавляет версию к JS файлу
		 * @param string $crs - Путь к оы файлу
		 * @param string|null $version - Версия
		 * @return string
		 */
		public function appendVersion(string $crs, ?string $version): string {
			$matches = [];
			preg_match('/^(.*)\.js$/', $crs, $matches);
			$path = $matches['1'];
			return "{$path}.{$version}.js";
		}

		/**
		 * Выводит JS файлы
		 * @return void
		 */
		public function browse(): void {
			foreach ($this->scripts as $src) { ?><script src = "<?= $src; ?>"></script><?php }
		}

	}