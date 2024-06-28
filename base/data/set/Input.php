<?php

	namespace Base\Data\Set;

	require_once 'Data.php';
	require_once 'Get.php';
	require_once 'Post.php';
	require_once 'Request.php';
	require_once 'Defined.php';

	class Input {
		private Get $get;
		private Post $post;
		private Request $request;
		private Defined $defined;

		public function __construct() {
			$this->get = new Get();
			$this->post = new Post();
			$this->request = new Request();
			$this->defined = new Defined();
		}

		public function get(string $key): Get {
			$this->get->key($key);
			return $this->get;
		}

		public function post(string $key): Post {
			$this->post->key($key);
			return $this->post;
		}

		public function request(string $key): Request {
			$this->request->key($key);
			return $this->request;
		}

		public function defined(string $key): Defined {
			$this->defined->key($key);
			return $this->defined;
		}

	}