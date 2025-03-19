<?php

	declare(strict_types=1);

	namespace Base\Editor;

	use Base\Access as BaseAccess;

	/**
	 * Базовый класс работы с правами редактора
	 */
	trait Access {
		const ACCESS_SETTING		= 1;
		const ACCESS_SELECT			= 'select';
		const ACCESS_BROWSE			= 3;
		const ACCESS_CREATE			= 4;
		const ACCESS_UPDATE			= 5;
		const ACCESS_DELETE			= 6;
		const ACCESS_STATE			= 7;

		/**
		 * Регистрирует коллекцию и права
		 * @return void
		 */
		protected function regActions(): void {
			$this->addCollection();

			$this->addRight(self::ACCESS_SETTING, 'setting', __('Назначение прав'));
			$this->addRight(self::ACCESS_SELECT, 'select', __('Выборка'));
			$this->addRight(self::ACCESS_BROWSE, 'browse', __('Вывод'));
			$this->addRight(self::ACCESS_CREATE, 'create', __('Создание'));
			$this->addRight(self::ACCESS_UPDATE, 'update', __('Изменение'));
			$this->addRight(self::ACCESS_DELETE, 'delete', __('Удаление'));
			$this->addRight(self::ACCESS_STATE, 'state', __('Изменение состояния'));
		}

		/**
		 * Добавляет коллекцию
		 * @return void
		 */
		final protected function addCollection(): void {
			BaseAccess::addCollection($this->id, $this->name, $this->title);
		}

		/**
		 * Добавляет право в коллекцию
		 * @param int $right - Право
		 * @param string $name - Название
		 * @param string $title - Заголовок
		 * @return void
		 */
		final protected function addRight(int $right, string $name, string $title = ''): void {
			BaseAccess::addRight($this->id, $right, $name, $title);
		}

		/**
		 * Проверяет права на выборку
		 * @return bool
		 */
		final protected function allowSelect(): bool {
			return $this->allow(self::ACCESS_SELECT);
		}

		/**
		 * Проверяет права на вывод
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		final protected function allowBrowse(int $id): bool {
			return $this->allow(self::ACCESS_BROWSE, $id);
		}

		/**
		 * Проверяет права на создание
		 * @return bool
		 */
		final protected function allowCreate(): bool {
			return $this->allow(self::ACCESS_CREATE);
		}

		/**
		 * Проверяет права на изменение
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		final protected function allowUpdate(int $id): bool {
			return $this->allow(self::ACCESS_UPDATE, $id);
		}

		/**
		 * Проверяет права на удаление
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		final protected function allowDelete(int $id): bool {
			return $this->allow(self::ACCESS_DELETE, $id);
		}

		/**
		 * Проверяет права на изменение состояния
		 * @param int $id - Идентификатор
		 * @return bool
		 */
		final protected function allowState(int $id): bool {
			return $this->allow(self::ACCESS_STATE, $id);
		}

	}