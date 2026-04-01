<?php

	declare(strict_types=1);

	namespace Proj\Editors\Models\Locales;

	use Base\Editor\Model;
	use Base\Models;
	use stdClass;

	/**
	 * Model-editor
	 */
	class Translations extends Model {
		public function __construct() {
			parent::__construct('craft', 'locales_translations');
		}

		/**
		 * Выборка данных
		 * @param array $fields - Перечень полей для выборки
		 * @param int $page_current - Текущая страница
		 * @param int $page_entries - Количество записей на странице
		 * @param stdClass|null $params - Параметры
		 * @return array
		 */
		public function select(array $fields, int $page_current = 1, int $page_entries = 10, stdClass $params = null): array {
			/** @var Languages $modelLanguages */ $modelLanguages = model('locales.languages', Models::SOURCE_EDITORS);
			/** @var Aliases $modelAliases */ $modelAliases = model('locales.aliases', Models::SOURCE_EDITORS);

			$languages = $modelLanguages->getActive('id', 'code')->all();
			$languagesIds = array_column($languages, 'id');
			[$response, $ext] = $modelAliases->select(['*'], $page_current, $page_entries, $params);
			$aliases = $response->all();
			$aliasesIds = array_column($aliases, 'id');
			$translates = $this->getByLanguagesAndAliases($languagesIds, $aliasesIds);

			$out = [];
			foreach ($aliases as $alias) {
				$out[] = [
					'id' => $alias['id'],
					'name' => $alias['name'],
					'context' => $alias['context_name'],
					'uses' => [
						'php' => $alias['use_php'],
						'js' => $alias['use_js'],
					],
					'translates' => $translates[$alias['id']] ?? [],
				];
			}

			return [['languages' => $languages, 'translations' => $out], $ext];
		}

		private function getByLanguagesAndAliases(array $languages, array $aliases): array {
			$items = $this->db->select()
				->table($this->table)
				->fields('id', 'language', 'alias', 'value')
				->where('state', self::STATE_DELETE, '!=')
				->where('state', self::STATE_ERROR, '!=')
				->whereIn('language', $languages)
				->whereIn('alias', $aliases)
				->query()
				->all();

			$out = [];
			foreach ($items as $item) {
				$out[$item['alias']][$item['language']] = ['id' => $item['id'], 'value' => $item['value']];
			}

			return $out;
		}

	}
