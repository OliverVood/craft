<?php

//	namespace base\db\driver\SQLite;
//
//	class DB extends \Base\DB\DB {
//		private string $file;
//
//		/**
//		 * Создаёт новый экземпляр базы данных
//		 * @param string $file - Файл SQLLite
//		 */
//		protected function __construct(string $file) {
//			parent::__construct();
//
//			$this->file = $file;
//
//			$this->link();
//		}
//
//		/**
//		 * Пытается установить соединение с базой данных
//		 * @return void
//		 */
//		protected function link(): void {
//			$this->state = true;
//		}
//
//		/**
//		 * Экранирует специальные символы
//		 * @param string $text - Текст
//		 * @return string
//		 */
//		public function escape(string $text): string {
//			return '';
//		}
//
//	}