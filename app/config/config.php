<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Postgresql',
        'host'        => 'localhost',
        'username'    => 'vgpg_user',
        'password'    => 'q1w2e3',
        'dbname'      => 'vgpg_cms',
        'schema'      => 'public',
        'port'        => '5432',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'formsDir'       => APP_PATH . '/app/forms/',
        'libraryDir'     => APP_PATH . '/library/',
        'messagesDir'    => APP_PATH . '/app/messages/',
        'aclDir'         => APP_PATH . '/app/acl/',
        'baseUri'        => 'https://phalcon-proj-marcos-sandim.c9.io',
        'menu'           => APP_PATH . '/app/config/menu.php',
        'routes'         => APP_PATH . '/app/config/routes.php',
    )
));
