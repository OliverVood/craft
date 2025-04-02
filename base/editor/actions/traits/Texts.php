<?php

	declare(strict_types=1);

	namespace Base\Editor\Actions\Traits;

	/**
	 * Работа с текстами и переводами
	 */
	trait Texts {
		private array $texts = [];

		/**
		 * Возвращает текст
		 * @param string $alias - Псевдоним
		 * @param string|null $text - Текст
		 * @return string
		 */
		public function text(string $alias, ?string $text = null): string {
			if ($text) $this->texts[$alias] = $text;

			return $this->texts[$alias] ?? 'TEXT NOT FOUND';
		}

		/**
		 * Возвращает перевод текста
		 * @param string $alias
		 * @return string
		 */
		public function __(string $alias): string {
			return __($this->text($alias));
		}

	}