<?php

	namespace Base\UI;

	/**
	 * Агрегатор SEO
	 */
	class SEO {
		private string $title = '';
		private string $description = '';
		private string $keywords = '';

		/**
		 * Задаёт заголовок страницы
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function setTitle(string $title): void {
			$this->title = $title;
		}

		/**
		 * Возвращает заголовок страницы
		 * @return string
		 */
		public function getTitle(): string {
			return $this->title;
		}

		/**
		 * Задаёт описание страницы
		 * @param string $description - Описание
		 * @return void
		 */
		public function setDescription(string $description): void {
			$this->title = $description;
		}

		/**
		 * Возвращает описание страницы
		 * @return string
		 */
		public function getDescription(): string {
			return $this->description;
		}

		/**
		 * Задает ключевые слова страницы
		 * @param string $keywords - Ключевые слова
		 * @return void
		 */
		public function setKeyword(string $keywords): void {
			$this->keywords = $keywords;
		}

		/**
		 * Возвращает ключевые слова страницы
		 * @return string
		 */
		public function getKeywords(): string {
			return $this->keywords;
		}

		/**
		 * Вывод SEO
		 * @return void
		 */
		public function browse(): void {
			if ($this->title) ?><title><?= $this->title; ?></title><?php
			if ($this->description) ?><meta name = "description" content = "<?= $this->description; ?>"><?php
			if ($this->keywords) ?><meta name = "keywords" content = "<?= $this->keywords; ?>"><?php
		}

	}