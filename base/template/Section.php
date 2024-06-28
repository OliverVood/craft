<?php

	namespace Base\Template;

	class Section {
		private array $contents = [];

		public function push(string ...$contents): void {
			foreach ($contents as $content) $this->contents[] = $content;
		}

		public function browse(): void {
			foreach ($this->contents as $content) echo $content;
		}

	}