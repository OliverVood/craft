<?php

	declare(strict_types=1);

	namespace Base\Data;

	require_once 'Base.php';

	require_once 'Get.php';
	require_once 'Post.php';
	require_once 'Request.php';
	require_once 'Input.php';
	require_once 'InputArray.php';
	require_once 'Defined.php';
	require_once 'Old.php';

	/**
	 * Агрегатор пользовательских данных
	 */
	class Set {
		private Get $get;
		private Post $post;
		private Request $request;
		private Input $input;
		private InputArray $inputArray;
		private Defined $defined;
		private Old $old;

		public function __construct() {
			$this->get = new Get();
			$this->post = new Post();
			$this->request = new Request();
			$this->input = new Input();
			$this->inputArray = new InputArray();
			$this->defined = new Defined();
			$this->old = new Old();

			$this->saveOld();
		}

		/**
		 * Возвращает данные по ключу из суперглобального массива $_GET
		 * @param string $key - Ключ
		 * @return Get
		 */
		public function get(string $key): Get {
			$this->get->key($key);
			return $this->get;
		}

		/**
		 * Возвращает данные по ключу из суперглобального массива $_POST
		 * @param string $key - Ключ
		 * @return Post
		 */
		public function post(string $key): Post {
			$this->post->key($key);
			return $this->post;
		}

		/**
		 * Возвращает данные по ключу из суперглобального массива $_REQUEST
		 * @param string $key - Ключ
		 * @return Request
		 */
		public function request(string $key): Request {
			$this->request->key($key);
			return $this->request;
		}

		/**
		 * Возвращает данные из контента
		 * @return Input
		 */
		public function input(): Input {
			return $this->input;
		}

		/**
		 * Возвращает данные по ключу из контента в виде ассоциативного массива
		 * @param string $key - Ключ
		 * @return InputArray
		 */
		public function inputArray(string $key): InputArray {
			$this->inputArray->key($key);
			return $this->inputArray;
		}

		/**
		 * Возвращает данные по ключу из суперглобального массива $_POST, если не нашёл, то из суперглобального массива $_GET (порядок определён и не зависит от настроек сервера)
		 * @param string|null $key - Ключ
		 * @return Defined
		 */
		public function defined(?string $key = null): Defined {
			if (isset($key)) $this->defined->key($key);
			return $this->defined;
		}

		/**
		 * Возвращает данные от предыдущего запроса
		 * @param string|null $key - Ключ
		 * @return Old
		 */
		public function old(?string $key = null): Old {
			if (isset($key)) $this->old->key($key);
			return $this->old;
		}

		/**
		 * Сохраняет данные от предыдущего запроса
		 */
		public function saveOld(): void {
			$_SESSION['__old'] = $this->defined->all();
		}

	}