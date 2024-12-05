<?php

	namespace Base\Helper;

	use Base\Link\Right as LinkAccess;
	use Base\Template\Buffer;

	/**
	 * Пагинация
	 */
	class Pagination {
		use Buffer;

		private LinkAccess $act;

		private int $current;
		private int $count;

		private string $name;

		public function __construct(LinkAccess $act, int $current, int $count, string $name = 'page') {
			$this->act = $act;

			$this->current = $current;
			$this->count = $count;

			$this->name = $name;
		}

		/**
		 * Возвращает пагинацию в виде HTML строки
		 * @return string
		 */
		public function __toString(): string {
			$this->start();
			if ($this->count > 1) {
				echo '<div class = "pagination">';
				if ($this->current > 1) {
					echo $this->first(1);
					echo $this->previous($this->current - 1);
				}
				echo $this->current($this->current);
				if ($this->current < $this->count) {
					echo $this->next($this->current + 1);
					echo $this->last($this->count);
				}
				echo '</div>';
			}
			return $this->read();
		}

		/**
		 * Возвращает текущую страницу в виде HTML строки
		 * @param int $number - Номер страницы
		 * @return string
		 */
		private function current(int $number): string {
			return "<a class = 'current'>$number</a>";
		}

		/**
		 * Возвращает предыдущую страницу в виде HTML строки
		 * @param int $number - Номер страницы
		 * @return string
		 */
		private function previous(int $number): string {
			return $this->link($number, '‹', 'previous');
		}

		/**
		 * Возвращает следующую страницу в виде HTML строки
		 * @param int $number - Номер страницы
		 * @return string
		 */
		private function next(int $number): string {
			return $this->link($number, '›', 'next');
		}

		/**
		 * Возвращает первую страницу в виде HTML строки
		 * @param int $number - Номер страницы
		 * @return string
		 */
		private function first(int $number): string {
			return $this->link($number, '«', 'first');
		}

		/**
		 * Возвращает последнюю страницу в виде HTML строки
		 * @param int $number - Номер страницы
		 * @return string
		 */
		private function last(int $number): string {
			return $this->link($number, '»', 'last');
		}

		/**
		 * Возвращает ссылку на страницу в виде HTML строки
		 * @param int $number - Номер страницы
		 * @param string $content - Текст ссылки
		 * @param string $class - Класс
		 * @return string
		 */
		private function link(int $number, string $content, string $class = ''): string {
			return $this->act->linkHref($content, [$this->name => $number], ['class' => $class]);
		}

	}