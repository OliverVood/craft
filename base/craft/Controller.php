<?php

	declare(strict_types=1);

	namespace Base\Craft;

	/**
	 * Craft. Работа с контроллерами
	 */
	abstract class Controller {
		const COMMAND_CREATE			= 'create';

		/**
		 * Запускает Craft для контроллеров
		 * @param string $command - Команда
		 * @param string $name - Наименование
		 * @param array $flags - Флаги
		 * @return bool
		 */
		static public function run(string $command, string $name, array $flags): bool {
			switch ($command) {
				case self::COMMAND_CREATE: return self::create($name, $flags);
				default: Message::error("Команда {$command}' не найдена"); return false;
			}
		}

		/**
		 * Создаёт контроллер
		 * @param string $name
		 * @param array $flags
		 * @return bool
		 */
		static private function create(string $name, array $flags): bool {
			$sample = file_get_contents(DIR_BASE . 'craft/samples/controller.sample');

			preg_match('/^((.*)\.)?(.+)$/', $name, $matches);

			/* Формирование имени */
			$parts = explode('_', $matches[3]);
			$parts = array_map(function ($part) { return ucfirst(strtolower($part)); }, $parts);
			$class = implode('', $parts);

			/* Формирование пути и пространства имён */
			$namespace = 'Proj\Controllers';
			$namespaceSuffix = '';
			$path = DIR_PROJ_CONTROLLERS;

			if ($matches[2] !== '') {
				/* Формирование пространства имён */
				$result = array_map(function ($elem) {
					$parts = explode('_', $elem);
					$parts = array_map(function ($part) { return ucfirst(strtolower($part)); }, $parts);
					return implode('', $parts);
				}, explode('.', $matches[2]));

				$namespaceSuffix = '\\' . implode('\\', $result);
				$namespace .= $namespaceSuffix;

				/* Формирование пути */
				$result = array_map(function ($elem) {
					$parts = explode('_', $elem);
					$parts = array_map(function ($part) { return ucfirst(strtolower($part)); }, $parts);
					return lcfirst(implode('', $parts));
				}, explode('.', $matches[2]));

				$path = $path . implode('/', $result) . '/';
			}

			$useModel = array_intersect(['-model', '-m'], $flags);

			$replace = [
				'<NAMESPASE>' => $namespace,
				'<CLASS>' => $class,
				'<USE_MODEL>' => $useModel ? "\n\tuse Proj\Models{$namespaceSuffix} as Model;" : '',
				'<MODEL>' => $useModel ? "\n\t\t\t/** @var Model \$model */ \$model = model('" . lcfirst($class) . "');\n" : '',
			];

			$sample = str_replace(array_keys($replace), $replace, $sample);
			dd($sample);

			self::writeFile("{$path}{$class}.php", $sample);

			Message::success("Контроллер '{$class}' создан");
			return true;
		}

		private static function writeFile($name, string $content): void {//super_texts.my_test.my_class
			$info = pathinfo($name);

			if (!is_dir($info['dirname'])) mkdir($info['dirname'], 0777, true);
			file_put_contents("{$info['dirname']}/{$info['basename']}", $content);
		}

	}