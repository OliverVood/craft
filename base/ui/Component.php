<?php

	namespace Base\UI;

	use Base\Singleton;

	/**
	 * Компоненты
	 */
	class Component {
		use Singleton;

		/**
		 * Возвращает стилизованный checkbox
		 * @param string $text - Текст
		 * @param array $attributes - Атрибуты
		 * @return string
		 */
		public function checkbox(string $text = '', array $attributes = []): string {
			return component('admin.checkbox', compact('text', 'attributes'));
		}

	}