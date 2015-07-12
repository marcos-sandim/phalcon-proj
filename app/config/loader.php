<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
    )
)->registerNamespaces(
    array(
        'App\Forms'     => $config->application->formsDir,
        'App\Models'    => $config->application->modelsDir,
        'Library'       => $config->application->libraryDir,
    )
)
->register();
