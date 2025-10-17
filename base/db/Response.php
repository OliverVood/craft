<?php

	namespace Base\DB;

	use Generator;

	/**
	 * Дря работы с результатом запроса (базовый абстрактный класс)
	 */
	abstract class Response {

		/**
		 * Возвращает результат запроса в виде генератора
		 * @return Generator
		 */
		public function __invoke(): Generator {
			return $this->each();
		}

		/**
		 * Проверяет состояние выполненного запроса
		 * @return bool
		 */
		abstract protected function isState(): bool;

		/**
		 * Возвращает результат запроса в виде генератора
		 * @return Generator
		 */
		abstract protected function each(): Generator;

		/**
		 * Возвращает все записи
		 * @return array
		 */
		abstract protected function all(): array;

		/**
		 * Возвращает одну запись
		 * @return array|null
		 */
		abstract protected function get(): ?array;

		/**
		 * Возвращает одно поле
		 * @param string $name - Наименование поля, по умолчанию возьмёт первое
		 * @return string|null
		 */
		abstract protected function field(string $name = ''): ?string;

	}