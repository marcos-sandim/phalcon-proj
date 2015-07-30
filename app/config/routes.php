<?php

$router = new Phalcon\Mvc\Router(false);

/*$router->add('/', []);

$router->add('/:controller', array(
    'controller' => 1
))->convert('controller', function($controller) {
    return Phalcon\Text::camelize($controller);
});*/

$router->add('(?:/([\w-]+))?(?:/([\w-]+))?(/.*)*', array(
    'controller' => 1,
    'action' => 2,
    'params' => 3
))->convert('controller', function($controller) {
    return lcfirst(Phalcon\Text::camelize($controller));
})->convert('action', function($action) {
    $action = $action && is_string($action) ? $action : null;
    return lcfirst(Phalcon\Text::camelize($action));
});

$router->handle();
