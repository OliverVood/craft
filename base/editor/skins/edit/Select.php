<?php

	namespace Base\Editor\Skins\Edit;

	use Base\Editor\Skins\Skin;

	/**
	 * Скин для отображения селекта
	 */
	class Select extends Skin {
		private array $data;
		private array $params;

		public function __construct(string $name, string $title = '', $data = [], array $params = []) {
			parent::__construct('select', $name, $title);

			$this->data = $data;
			$this->params = $params;
		}

		/**
		 * Возвращает текстовое поле
		 * @param string $value
		 * @return string
		 */
		public function format(string $value): string {
			$this->start();
			?>
				<select name = "<?= $this->name; ?>">
					<?php if (isset($this->params['empty'])) { ?>
						<option value = "<?= $this->params['empty']['key']; ?>" class = "hide" disabled selected><?= $this->params['empty']['value']; ?></option>
					<?php } ?>
					<?php foreach ($this->data as $key => $val) {
						$selected = $key == $value ? ' selected' : '';
					?>
						<option value = "<?= $key; ?>"<?= $selected ?>><?= $val; ?></option>
					<?php } ?>
				</select>
			<?php
			return $this->cover($this->read());
		}

	}