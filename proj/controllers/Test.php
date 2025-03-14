<?php

	namespace Proj\Controllers;

	use AllowDynamicProperties;
	use Base\Controller;
	use Base\Data\Set\Input;
	use Base\Model;
	use Base\UI\View;
	use proj\ui\templates\site\Template;

	/**
	 * Тесты
	 * @property \Proj\Models\Test $test
	 */
	#[AllowDynamicProperties] class Test extends Controller {
		public function index(): void {
			echo 'index method';
		}

		public function one(Input $input): void {
			Template::$seo->setTitle('ONE PAGE');
			$this->test = Model::get('test');
			$data = $this->test->One();

			Template::$layout->main->push('KEY: ' . $input->get('key')->string());
			Template::$layout->main->push('KEY: ' . $input->request('key')->string('not found'));
			Template::$layout->main->push('KEY: ' . $input->post('null')->string('not found'));
			Template::$layout->main->push('KEY: ' . $input->defined('key')->string('not found'));
			Template::$layout->main->push(View::get('test.one', $data['one']));
			Template::$layout->main->push(View::get('test.two', $data['two']));
		}

		public function two(): void {
			echo 'one method';
		}

	}