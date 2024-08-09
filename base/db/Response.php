<?php

	namespace Base\DB;

	use Generator;

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
		 * Возвращает одну запись
		 * @return array|null
		 */
		abstract protected function getOne(): ?array;

		/**
		 * Возвращает одно поле
		 * @param string $name - Имя поля, по умолчанию возьмёт первое
		 * @return string|null
		 */
		abstract protected function getOneField(string $name = ''): ?string;

	}