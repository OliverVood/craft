<?php

	namespace Base\Template;

	class JS {
		private array $scripts = [];

		public function add(string $src): void{
			if (in_array($src, $this->scripts)) die("Script «{$src}» is already in use");
			$this->scripts[] = $src;
		}

		public function browse(): void {
			foreach ($this->scripts as $src) { ?><script src = "<?= $src; ?>"></script><?php }
		}

	}