<?php

	namespace Proj\Models;

	use Base\Model;

	class Test extends Model {
		public function One(): array {
			return [
				'one' => ['type' => 'ONE 7'],
				'two' => ['type' => 'THO 8']
			];
		}

	}