<?php

	namespace Base\Data\Set;

	require_once 'Data.php';
	require_once 'Get.php';
	require_once 'Post.php';
	require_once 'Request.php';
	require_once 'Defined.php';
	require_once 'Assoc.php';
	require_once 'Content.php';

	/**
	 * Агрегатор пользовательских данных
	 */
	class Input {
		private Get $get;
		private Post $post;
		private Request $request;
		private Defined $defined;
		private Assoc $assoc;
		private Content $content;

		public function __construct() {
			$this->get = new Get();
			$this->post = new Post();
			$this->request = new Request();
			$this->defined = new Defined();
			$this->assoc = new Assoc();
			$this->content = new Content();
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
		 * Возвращает данные по ключу из суперглобального массива $_POST, если не нашёл, то из суперглобального массива $_GET (порядок определён и не зависит от настроек сервера)
		 * @param string $key - Ключ
		 * @return Defined
		 */
		public function defined(string $key): Defined {
			$this->defined->key($key);
			return $this->defined;
		}

		/**
		 * Возвращает данные по ключу из контента в виде ассоциативного массива
		 * @param string $key - Ключ
		 * @return Assoc
		 */
		public function assoc(string $key): Assoc {
			$this->assoc->key($key);
			return $this->assoc;
		}

		/**
		 * Возвращает данные из контента
		 * @return Content
		 */
		public function content(): Content {
			return $this->content;
		}

	}