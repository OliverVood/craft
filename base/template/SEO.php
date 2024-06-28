<?php

	namespace Base\Template;

	class SEO {
		private string $title = '';
		private string $description = '';
		private string $keywords = '';

		public function setTitle(string $title): void {
			$this->title = $title;
		}

		public function getTitle(): string {
			return $this->title;
		}

		public function setDescription(string $description): void {
			$this->title = $description;
		}

		public function getDescription(): string {
			return $this->description;
		}

		public function setKeyword(string $keywords): void {
			$this->keywords = $keywords;
		}

		public function getKeywords(): string {
			return $this->keywords;
		}

		public function browse(): void {
			if ($this->title) ?><title><?= $this->title; ?></title><?php
			if ($this->description) ?><meta name = "description" content = "<?= $this->description; ?>"><?php
			if ($this->keywords) ?><meta name = "keywords" content = "<?= $this->keywords; ?>"><?php
		}

	}