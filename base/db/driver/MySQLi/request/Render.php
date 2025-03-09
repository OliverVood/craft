<?php

	namespace Base\DB\Driver\MySQLi\Request;

	/**
	 * Методы рендеринга запроса
	 */
	trait Render {
		/**
		 * Возвращает таблицу
		 * @return string
		 */
		private function renderTable(): string {
			return $this->shield($this->table);
		}

		/**
		 * Возвращает условия
		 * @return string
		 */
		private function renderConditions(): string {
			$list = [];
			$first = true;

			foreach ($this->conditions as $condition) {
				$connection = $first ? '' : " {$condition['connection']} ";
				$data = $condition['data'];
				switch ($condition['type']) {
					case 'where': $list[] = "{$connection}{$this->shield($data['field'])} {$data['operator']} '{$data['value']}'"; break;
					case 'compare': $list[] = "{$connection}{$this->shield($data['field1'])} {$data['operator']} {$this->shield($data['field2'])}"; break;
				}
				$first = false;
			}

			return $list ? ' WHERE ' . implode('', $list) : '';
		}

		/**
		 * Возвращает экранированные названий: баз данных, таблиц, полей
		 * @param string $str - Строка для экранирования
		 * @return string
		 */
		private function shield(string $str): string {
			$matchs = [];
			preg_match('/ *([^ ]*)( +(as +)?([^ ]*))? */', $str, $matchs);
			$name = $matchs[1];
			$as = $matchs[4] ?? null;

			$pieces = explode('.', $name);
			foreach ($pieces as & $piece) {
				if ($piece == '*') continue;
				$piece = "`{$piece}`";
			}
			$out = implode('.', $pieces);

			if ($as) $out .= " AS `{$as}`";

			return $out;
		}

	}