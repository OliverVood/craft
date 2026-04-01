<?php

	declare(strict_types=1);

	namespace Proj\Structures\Craft;

	use Base\DB\Table;

	/**
	 * Structure of translation tables
	 */
	class Translations {
		private Table $table_locales_languages;
		private Table $table_locales_contexts;
		private Table $table_locales_aliases;
		private Table $table_locales_translations;

		public function __construct() {
			$structure = app()->db('craft')->structure();

			$this->table_locales_languages = $structure->table('locales_languages', __('Languages'));
			$this->table_locales_languages->id('id', __('ID'));
			$this->table_locales_languages->string('code', 2, __('Code'));
			$this->table_locales_languages->uint8('state', __('Status'));
			$this->table_locales_languages->timestamp('datecr', false, __('Creation Date'));
			$this->table_locales_languages->timestamp('datemd', true, __('Modification Date'));

			$this->table_locales_contexts = $structure->table('locales_contexts', __('Translation contexts'));
			$this->table_locales_contexts->id('id', __('ID'));
			$this->table_locales_contexts->string('name', 10, __('Name'));
			$this->table_locales_contexts->uint8('state', __('Status'));
			$this->table_locales_contexts->timestamp('datecr', false, __('Creation Date'));
			$this->table_locales_contexts->timestamp('datemd', true, __('Modification Date'));

			$this->table_locales_aliases = $structure->table('locales_aliases', __('Aliases for translations'));
			$this->table_locales_aliases->id('id', __('ID'));
			$this->table_locales_aliases->uint32('context', __('Contest ID'));
			$this->table_locales_aliases->string('name', 100, __('Translation alias'));
			$this->table_locales_aliases->bool('use_php', __('Use in PHP'));
			$this->table_locales_aliases->bool('use_js', __('Use in JS'));
			$this->table_locales_aliases->uint8('state', __('Status'));
			$this->table_locales_aliases->timestamp('datecr', false, __('Creation Date'));
			$this->table_locales_aliases->timestamp('datemd', true, __('Modification Date'));
			$this->table_locales_aliases->addForeign('foreign_context', ['context'], 'locales_contexts', ['id']);

			$this->table_locales_translations = $structure->table('locales_translations', __('Translations'));
			$this->table_locales_translations->id('id', __('ID'));
			$this->table_locales_translations->uint32('language', __('Language ID'));
			$this->table_locales_translations->uint32('alias', __('Alias ID'));
			$this->table_locales_translations->string('value', 1000, __('Translate'));
			$this->table_locales_translations->uint8('state', __('Status'));
			$this->table_locales_translations->timestamp('datecr', false, __('Creation Date'));
			$this->table_locales_translations->timestamp('datemd', true, __('Modification Date'));
			$this->table_locales_translations->addForeign('foreign_language', ['language'], 'locales_languages', ['id']);
			$this->table_locales_translations->addForeign('foreign_alias', ['alias'], 'locales_aliases', ['id']);
		}

	}

	new Translations();
