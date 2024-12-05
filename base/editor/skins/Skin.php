<?php

	namespace Base\Editor\Skins;

	require DIR_BASE . 'editor/skins/Browse.php';
	require DIR_BASE . 'editor/skins/Edit.php';

	abstract class Skin {
		protected string $type;
		protected string $name;
		protected string $title;
		protected bool $hide;

		public function __construct(string $type, string $name, string $title, $hide = false) {
			$this->type = $type;
			$this->name = $name;
			$this->title = $title;
			$this->hide = $hide;
		}

		/**
		 * Возвращает тип скина
		 * @return string
		 */
		public function getType(): string {
			return $this->type;
		}

		/**
		 * Возвращает наименование для скина
		 * @return string
		 */
		public function getName(): string {
			return $this->name;
		}

		/**
		 * Возвращает заголовок для скина
		 * @return string
		 */
		public function getTitle(): string {
			return $this->title ?: $this->name;
		}

		/**
		 * Возвращает истину, если поле скрытое
		 * @return bool
		 */
		public function isHide(): bool {
			return $this->hide;
		}

		/**
		 * Форматирует и возвращает IP-адрес
		 * @param string $value
		 * @return string
		 */
		abstract public function format(string $value): string;

	}