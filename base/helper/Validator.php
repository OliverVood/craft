<?php

	declare(strict_types=1);

	namespace Base\Helper;

	/**
	 * Валидация данных
	 */
	abstract class Validator {
		/**
		 * Выполняет валидацию данных
		 * @param array $data - Данные
		 * @param array $list - Список правил
		 * @param array $names - Массив псевдонимов и имён
		 * @param array $errors - Ошибки
		 * @return array|null
		 */
		public static function execute(array $data, array $list, array $names = [], array & $errors = []): ?array {
			$out = [];

			$encryption = [];
			$unset = [];
			$unsetIfEmpty = [];

			$state = true;

			foreach ($list as $key => $rules) {
				$value = $data[$key] ?? null;
				$name = $names[$key] ?? $key;

				foreach ($rules as $rule) {
					[$rule, $arguments] = self::compoundRule($rule);

					switch ($rule) {
						case 'required': $value = self::required($key, $value, $name, $errors); break;
						case 'bool': case 'boolean': $value = self::bool($key, $value, $name, $errors); break;
						case 'int': case 'integer': $value = self::int($key, $value, $name, $errors); break;
						case 'float':case 'double': $value = self::float($key, $value, $name, $errors); break;
						case 'string':case 'text': $value = self::string($key, $value, $name, $errors); break;
						case 'in': $value = self::in($key, $value, $name, $arguments, $errors); break;
						case 'same': $value = self::same($key, $value, $name, $data[$arguments[0]] ?? null, $names[$arguments[0]] ?? $arguments[0], $errors); break;
						case 'min': if (in_array('required', $rules) || $value) $value = self::min($key, $value, $name, $arguments[0], $errors); break;
						case 'max': if (in_array('required', $rules) || $value) $value = self::max($key, $value, $name, $arguments[0], $errors); break;
						case 'contains': if (in_array('required', $rules) || $value) $value = self::contains($key, $value, $name, $arguments, $errors); break;
						case 'trim': $value = self::trim($value); break;
						case 'encryption': $encryption[] = $key; break;
						case 'unset': $unset[] = $key; break;
						case 'unset_if_empty': $unsetIfEmpty[] = $key; break;
						default: $value = null;
					}

					if ($value === null) { $state = false; break; }
				}
				$out[$key] = $value;
			}

			foreach ($encryption as $key) $out[$key] = self::encryption($out[$key]);
			foreach ($unset as $key) self::unset($key, $out);
			foreach ($unsetIfEmpty as $key) if ($out[$key] === '') self::unset($key, $out);

			return $state ? $out : null;
		}

		/**
		 * Парсит сложные правила
		 * @param string $rule - Правило
		 * @return array
		 *
		 */
		private static function compoundRule(string $rule): array {
			$arguments = [];
			$parts = explode(':', $rule);

			if (count($parts) == 1) return [$rule, $arguments];

			$rule = $parts[0];
			$arguments = explode(',', $parts[1]);

			return [$rule, $arguments];
		}

		/**
		 * Проверяет, является ли значение не пустым
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param $errors - Ошибки
		 * @return mixed
		 */
		private static function required(string $key, mixed $value, string $name, & $errors): mixed {
			if ($value !== null && $value !== '') return $value;

			$errors[$key][] = __('Поле «:[name]» обязательно для заполнения', ['name' => $name]);

			return null;
		}

		/**
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param $errors - Ошибки
		 * @return bool|null
		 */
		private static function bool(string $key, mixed $value, string $name, & $errors): ?bool {
			if ($value === true || $value === 1 || $value === '1') return true;
			if ($value === false || $value === 0 || $value === '0') return false;

			$errors[$key][] = __('Значение поля «:[name]» не является логическим', ['name' => $name]);

			return null;
		}

		/**
		 * Проверяет, является ли значение целым числом
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param $errors - Ошибки
		 * @return int|null
		 */
		private static function int(string $key, mixed $value, string $name, & $errors): ?int {
			if ((string)$value === (string)(int)$value) return (int)$value;

			$errors[$key][] = __('Значение поля «:[name]» не является целым числом', ['name' => $name]);

			return null;
		}

		/**
		 * Проверяет, является ли значение дробным или целым числом
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param $errors - Ошибки
		 * @return int|null
		 */
		private static function float(string $key, mixed $value, string $name, & $errors): ?int {
			if ((string)$value === (string)(float)$value) return (float)$value;

			$errors[$key][] = __('Значение поля «:[name]» не является числом', ['name' => $name]);

			return null;
		}

		/**
		 * Проверяет, является ли значение строкой
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param $errors - Ошибки
		 * @return string|null
		 */
		private static function string(string $key, mixed $value, string $name, & $errors): ?string {
			if (is_int($value) || is_float($value) || is_string($value)) return (string)$value;

			$errors[$key][] = __('Значение поля «:[name]» не является строкой', ['name' => $name]);

			return null;
		}

		/**
		 * Проверяет, входит ли значение в массив
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param array $data - Массив
		 * @param $errors - Ошибки
		 * @return array|null
		 */
		private static function in(string $key, mixed $value, string $name, array $data, & $errors): mixed {
			if (in_array($value, $data)) return $value;

			$errors[$key][] = __('Значение поля «:[name]» не допустимо', ['name' => $name]);

			return null;
		}

		/**
		 * Проверяет, совпадают ли значения
		 * @param string $key - Ключ
		 * @param string $value - Значение
		 * @param string $name - Имя
		 * @param string $valueOriginal - Оригинальное значение
		 * @param string $nameOriginal - Оригинальное имя
		 * @param $errors - Ошибки
		 * @return mixed
		 */
		private static function same(string $key, string $value, string $name, string $valueOriginal, string $nameOriginal, & $errors): mixed {
			if ($value === $valueOriginal) return $value;

			$errors[$key][] = __('Значение поля «:[name]» не совпадает cо значением поля «:[name_original]»', ['name' => $name, 'name_original' => $nameOriginal]);

			return null;
		}

		/**
		 * Проверяет значение на минимальную длину символов
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param int $min - Минимальная длина
		 * @param $errors - Ошибки
		 * @return mixed
		 */
		private static function min(string $key, mixed $value, string $name, int $min, & $errors): mixed {
			if (mb_strlen($value) >= $min) return $value;

			$errors[$key][] = __('Длина поля «:[name]» не может быть меньше :[min]', ['name' => $name, 'min' => $min]);

			return null;
		}

		/**
		 * Проверяет значение на максимальную длину символов
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param int $max - Максимальная длина
		 * @param $errors - Ошибки
		 * @return mixed
		 */
		private static function max(string $key, mixed $value, string $name, int $max, & $errors): mixed {
			if (mb_strlen($value) <= $max) return $value;

			$errors[$key][] = __('Длина поля «:[name]» не может быть больше :[max]', ['name' => $name, 'max' => $max]);

			return null;
		}

		/**
		 * Проверяет значение на вхождение символов
		 * @param string $key - Ключ
		 * @param mixed $value - Значение
		 * @param string $name - Имя
		 * @param array $rules - Правила
		 * @param $errors - Ошибки
		 * @return mixed
		 */
		private static function contains(string $key, mixed $value, string $name, array $rules, & $errors): mixed {
			foreach ($rules as $rule) {
				switch ($rule) {
					case 'number': if (!preg_match('/[0-9]/', $value)) { $errors[$key][] = __('Поле «:[name]» должно содержать цифры', ['name' => $name]); return null; } break;
					case 'letter': if (!preg_match('/[a-zA-Z]/', $value)) { $errors[$key][] = __('Поле «:[name]» должно содержать буквы', ['name' => $name]); return null; } break;
					case 'lowercase': if (!preg_match('/[a-zа-я]/', $value)) { $errors[$key][] = __('Поле «:[name]» должно содержать строчные буквы', ['name' => $name]); return null; } break;
					case 'uppercase': if (!preg_match('/[A-ZА-Я]/', $value)) { $errors[$key][] = __('Поле «:[name]» должно содержать прописные буквы', ['name' => $name]); return null; } break;
					case 'special': if (!preg_match('/[^0-9a-zA-Zа-яА-Я]/', $value)) { $errors[$key][] = __('Поле «:[name]» должно содержать специальные символы', ['name' => $name]); return null; } break;
					default: return null;
				}
			}

			return $value;
		}

		/**
		 * Обрезает значение
		 * @param string $value - Значение
		 * @return string
		 */
		private static function trim(string $value): string {
			return trim($value);
		}

		/**
		 * Шифрует значение
		 * @param string $value - Значение
		 * @return string
		 */
		private static function encryption(string $value): string {
			return encryption($value);
		}

		/**
		 * Удаляет элемент из массива данных
		 * @param string $key - Ключ
		 * @param array $data - Данные
		 * @return void
		 */
		private static function unset(string $key, array & $data): void {
			unset($data[$key]);
		}

	}