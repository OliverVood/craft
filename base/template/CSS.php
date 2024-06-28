<?php

	namespace Base\Template;

	class CSS {
		private array $stylesheets = [];

		public function add(string $href): void{
			if (in_array($href, $this->stylesheets)) die("Stylesheets «{$href}» is already in use");
			$this->stylesheets[] = $href;
		}

		public function browse(): void {
			foreach ($this->stylesheets as $url) { ?><link rel = "stylesheet" href = "<?= $url; ?>" type = "text/css"><?php }
		}

	}