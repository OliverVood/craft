<?php

	declare(strict_types=1);

	namespace Base\Helper;

	use Base\Singleton;
	use JetBrains\PhpStorm\NoReturn;

	class Redirect {
		use Singleton;

		#[NoReturn] public function page404(): void {
			header('Location: ' .  linkInternal('404')->path());
			die();
		}

	}