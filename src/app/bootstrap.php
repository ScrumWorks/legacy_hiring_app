<?php

use Nette\Utils\Strings;
use Tracy\Debugger;

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setDebugMode(true);
$configurator->enableTracy(__DIR__ . '/../log/');

if (!isset($tempDir)) {
	$tempDir = __DIR__ . '/../temp';
}

$configurator->setTempDirectory($tempDir);

// Enable RobotLoader - this will load all classes automatically
$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');

return $configurator;
