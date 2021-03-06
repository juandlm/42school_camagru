<?php
namespace Camagru\Core;

class Autoloader
{
	public function __construct() {
		spl_autoload_register(function (string $class) {
			$replaceRootPath = str_replace("Camagru\\", APP, $class);
			$replaceDirectorySeparator = str_replace('\\', '/', $replaceRootPath);
			$filePath = $replaceDirectorySeparator . ".php";
			if (file_exists($filePath))
				require ($filePath);
		});
	}
}