<?php

	namespace Base\Helper;

	use Base\Controllers;
	use Base\DB\DB;
	use Base\Models;
	use Base\Singleton;
	use JetBrains\PhpStorm\NoReturn;
	use Proj\Models\Users;
	use ReflectionClass;
	use ReflectionClassConstant;
	use ReflectionException;
	use ReflectionMethod;
	use ReflectionProperty;

	/**
	 * Отладчик
	 */
	class Debugger {
		use Singleton;

		private array $variables = [];

		private function __construct() {  }

		/**
		 * Печатает переменную
		 * @param mixed $variable - Переменная
		 * @param string $title - Заголовок
		 * @return void
		 */
		public function dump(mixed $variable, string $title = ''): void {
			if (!$this->useDebugger()) return;

			if (env('APP_DEBUGGER_VARIABLE_SEND', '0')) {
				$this->variables[] = ['title' => $title, 'var' => $this->parsingVariable($variable)];
				return;
			}
		?>
			<b><?= $title; ?></b>
			<pre><?php var_dump($variable); ?></pre>
		<?php }

		/**
		 * Печатает переменную и завершает работу программы
		 * @param mixed $variable - Переменная
		 * @param string $title - Заголовок
		 * @return void
		 */
		#[NoReturn] public function dd(mixed $variable, string $title = ''): void {
			if (!$this->useDebugger()) return;

			$this->dump($variable, $title);
			die();
		}

		/**
		 * Проверяет можно ли выводить отладочную информацию
		 * @return bool
		 */
		public function useDebugger(): bool {
			return (bool)env('APP_DEBUGGER', '0');
		}

		/**
		 * Возвращает лог дебагера
		 * @return array[]
		 */
		public function getLog(): array {
			/** @var Users $users */ $users = model('users');

			return [
				'network' => [
					'method' => app()->request()->method(),
					'method_virtual' => app()->request()->methodVirtual(),
					'url' => app()->request()->urlBase(),
					'ip' => app()->request()->clientIP(),
				],
				'get' => $this->parsingVariable(get()->all()),
				'post' => $this->parsingVariable(post()->all()),
				'files' => $this->parsingVariable($_FILES),
				'variables' => $this->variables,
				'queries' => DB::getHistory(),
				'controllers' => Controllers::getHistory(),
				'models' => Models::getHistory(),
				'timestamps' => Timestamp::list(),
				'user' => [
					'id' => $users->getId(),
					'alias' => $users->getAlias(),
				],
			];
		}

		/**
		 * Разбирает переменную
		 * @param mixed $var - переменная
		 * @return array
		 */
		private function parsingVariable(mixed $var): array {
			$type = gettype($var);
			return match ($type) {
				'boolean' => ['type' => $type, 'value' => $var ? 'true' : 'false'],
				'integer', 'double', 'string' => ['type' => $type, 'value' => $var],
				'NULL' => ['type' => 'null', 'value' => $var],
				'array' => ['type' => $type, 'value' => $this->parsingArray($var)],
				'object' => ['type' => $type, 'value' => $this->parsingObject($var)],
				default => ['type' => $type],
			};
		}
		
		/**
		 * Разбирает массив
		 * @param array $array - массив
		 * @return array
		 */
		private function parsingArray(array $array): array {
			$out = [];
			foreach ($array as $key => $value) {
				$out[] = [
					'key' => $this->parsingVariable($key),
					'value' => $this->parsingVariable($value)
				];
			}

			return $out;
		}

		/**
		 * Разбирает объект
		 * @param object $object - Объект
		 * @return array
		 */
		private function parsingObject(object $object): array {
			$parseModifiers = function (int $modifiers): array {
				$out = [];

				if ($modifiers & ReflectionClass::IS_IMPLICIT_ABSTRACT) {						// PHP >= 7.4.0
					$out[] = 'abstract';
					$out[] = 'implicit';
				}
				if ($modifiers & ReflectionClass::IS_EXPLICIT_ABSTRACT) {						// PHP >= 7.4.0
					$out[] = 'abstract';
					$out[] = 'explicit';
				}
				if ($modifiers & ReflectionClass::IS_FINAL) $out[] = 'final';					// PHP >= 7.4.0
//				if ($modifiers & ReflectionClass::IS_READONLY) $out[] = 'readonly';				// PHP >= 8.2.0

				return $out;
			};

			$reflection = new ReflectionClass($object);

			return [
				'namespace' => $reflection->getNamespaceName(),
				'name' => $reflection->getShortName(),
				'modifiers' => $parseModifiers($reflection->getModifiers()),
				'constants' => self::getObjectConstants($reflection),
				'properties' => self::getObjectProperties($reflection, $object),
				'methods' => self::getObjectMethods($reflection),
			];
		}

		/**
		 * Разбирает константы объекта
		 * @param ReflectionClass $reflection
		 * @return array
		 */
		private function getObjectConstants(ReflectionClass $reflection): array {

			$parseModifiers = function (int $modifiers): array {
				$out = [];

				if ($modifiers & ReflectionClassConstant::IS_PUBLIC) $out[] = 'public';			// PHP >= 7.4.0
				if ($modifiers & ReflectionClassConstant::IS_PROTECTED) $out[] = 'protected';	// PHP >= 7.4.0
				if ($modifiers & ReflectionClassConstant::IS_PRIVATE) $out[] = 'private';		// PHP >= 7.4.0
//				if ($modifiers & ReflectionClassConstant::IS_FINAL) $out[] = 'final';			// PHP >= 8.1.0

				return $out;
			};

			$out = [];
			$constants = $reflection->getConstants();
			foreach ($constants as $name => $value) {
				$reflectionConstant = $reflection->getReflectionConstant($name);

				$modifiers		= $parseModifiers($reflectionConstant->getModifiers());
				$name			= $reflectionConstant->getName();
				$value			= $this->parsingVariable($reflectionConstant->getValue());

				$out[] = compact('modifiers', 'name', 'value');
			}

			return $out;
		}

		/**
		 * Разбирает свойства объекта
		 * @param ReflectionClass $reflection
		 * @param object $object - Объект
		 * @return array
		 */
		private function getObjectProperties(ReflectionClass $reflection, object $object): array {

			$parseModifiers = function (int $modifiers): array {
				$out = [];

				if ($modifiers & ReflectionProperty::IS_PUBLIC) $out[] = 'public';				// PHP >= 7.4.0
				if ($modifiers & ReflectionProperty::IS_PROTECTED) $out[] = 'protected';		// PHP >= 7.4.0
				if ($modifiers & ReflectionProperty::IS_PRIVATE) $out[] = 'private';			// PHP >= 7.4.0
				if ($modifiers & ReflectionProperty::IS_STATIC) $out[] = 'static';				// PHP >= 7.4.0
//				if ($modifiers & ReflectionProperty::IS_READONLY) $out[] = 'readonly';			// PHP >= 8.1.0

				return $out;
			};

			$out = [];
			$properties = $reflection->getProperties();
			foreach ($properties as $property) {
				try {
					$reflectionProperty = $reflection->getProperty($property->name);
				} catch (ReflectionException) {
					continue;
				}

				$reflectionProperty->setAccessible(true);

				$modifiers		= $parseModifiers($reflectionProperty->getModifiers());
				$name			= $reflectionProperty->getName();
				$value			= $this->parsingVariable($reflectionProperty->getValue($property->isStatic() ? null : $object));

				$out[] = compact('modifiers', 'name', 'value');
			}

			return $out;
		}

		/**
		 * Разбирает методы объекта
		 * @param ReflectionClass $reflection
		 * @return array
		 */
		private function getObjectMethods(ReflectionClass $reflection): array {

			$parseModifiers = function (int $modifiers): array {
				$out = [];

				if ($modifiers & ReflectionMethod::IS_PUBLIC) $out[] = 'public';				// PHP >= 7.4.0
				if ($modifiers & ReflectionMethod::IS_PROTECTED) $out[] = 'protected';			// PHP >= 7.4.0
				if ($modifiers & ReflectionMethod::IS_PRIVATE) $out[] = 'private';				// PHP >= 7.4.0
				if ($modifiers & ReflectionMethod::IS_FINAL) $out[] = 'final';					// PHP >= 7.4.0
				if ($modifiers & ReflectionMethod::IS_STATIC) $out[] = 'static';				// PHP >= 7.4.0
				if ($modifiers & ReflectionMethod::IS_ABSTRACT) $out[] = 'abstract';			// PHP >= 7.4.0

				return $out;
			};

			$out = [];
			$methods = $reflection->getMethods();
			foreach ($methods as $method) {
				try {
					$reflectionMethod = $reflection->getMethod($method->name);
				} catch (ReflectionException) {
					continue;
				}

				$modifiers		= $parseModifiers($reflectionMethod->getModifiers());
				$name 			= $reflectionMethod->getName();

				$out[] = compact('modifiers', 'name');
			}

			return $out;
		}

	}