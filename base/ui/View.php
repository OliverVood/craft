<?php

	declare(strict_types=1);

	namespace Base\UI;

	/**
	 * Базовый класс для работы с отображениями
	 */
	abstract class View {
		/**
		 * Возвращает отображение
		 * @param string $name - Наименование отображения
		 * @param array $data - Данные
		 * @param bool $showName - Показывать ли имя отображения
		 * @param bool $showVarsKeys - Показывать ли ключи переменных
		 * @param bool $showVars - Показывать ли переменные
		 * @return string
		 */
		public static function get(string $name, array $data = [], bool $showName = false, bool $showVarsKeys = false, bool $showVars = false): string {
			$name = str_replace('.', '/', $name);

			/**
			 * Загружает отображение
			 * @param string $___name___ - Имя отображения
			 * @param $___data___ - Данные
			 * @return void
			 */
			$view = function (string $___name___, $___data___) {
				extract($___data___, EXTR_SKIP);

				require DIR_PROJ_VIEWS . "{$___name___}.tpl";
			};

			buffer()->start();

			if ($showName) dump($name, 'view name');
			if ($showVarsKeys) dump(array_keys($data), 'data keys');
			if ($showVars) dump($data, 'data');

			$view($name, $data);

			return buffer()->read();
		}

	}