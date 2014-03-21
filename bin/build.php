<?php

use Aura\Cli\CliFactory;
use Matthias\SphinxDocumentation\ServiceContainer;

$autoloadFile = array_filter(
    array(
        __DIR__ . '/../vendor/autoload.php',
        __DIR__ . '/../../../autoload.php'
    ),
    'file_exists'
);

if ($autoloadFile === null) {
    throw new \RuntimeException('Could not locate the Composer autoload file');
}

require reset($autoloadFile);

$cli_factory = new CliFactory;
$context = $cli_factory->newContext($GLOBALS);
$getopt = $context->getopt(
    array(
        'library-dir*:',
        'project-dir:'
    )
);

$projectDirectory = $getopt->get('--project-dir', getcwd());
$buildDirectory = $getopt->get(1);
$libraryDirectories = $getopt->get('--library-dir');

$serviceContainer = new ServiceContainer($projectDirectory, $buildDirectory, $libraryDirectories, true);

$serviceContainer->getBuilder()->build();
