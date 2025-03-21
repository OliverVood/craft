<?php

	declare(strict_types=1);

	namespace Base\Editor\Skins;

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
		 * Помещает элемент в обвёртку
		 * @param string $element - Элемент
		 * @return string
		 */
		protected function cover(string $element): string {
			buffer()->start();
			?>
				<div data-field = "<?= $this->name; ?>">
					<?= $element; ?>
					<div class = "errors"></div>
				</div>
			<?php
			return buffer()->read();
		}

		/**
		 * Форматирует и возвращает IP-адрес
		 * @param string $value
		 * @return string
		 */
		abstract public function format(string $value): string;

	}

	require DIR_BASE . 'editor/skins/Browse.php';
	require DIR_BASE . 'editor/skins/Edit.php';