<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo as DbPdo;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Text;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Flash\Session as Flash;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
* add routing capabilities
*/
$di->set('router', function () use($config) {
    require $config->application->routes;
    return $router;
});

$di->set('dispatcher', function () use($di) {
    // Create an EventsManager
    $eventsManager = new EventsManager();

    $eventsManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) {
        // Handle 404 exceptions
        if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
            $dispatcher->forward(array(
                'controller' => 'error',
                'action' => 'notFound'
            ));
            return false;
        }

        // Alternative way, controller or action doesn't exist
        /*if ($event->getType() == 'beforeException') {
            switch ($exception->getCode()) {
                case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(array(
                        'controller' => 'error',
                        'action' => 'notFound'
                    ));
                    return false;
            }
        }*/
    });

    $eventsManager->attach("dispatch:beforeDispatch", function ($event, $dispatcher) use($eventsManager) {
        $className = ucfirst($dispatcher->getControllerName()) . 'Controller';
        $methodName = $dispatcher->getActionName().'Action';
        try {
            $refMethod = (new \ReflectionClass($className))->getMethod($methodName);
            if ($refMethod->name != $methodName) {
                $e = new \Phalcon\Mvc\Dispatcher\Exception("Method {$methodName} does not exist, did ou mean {$refMethod->name}?");
                $eventsManager->fire('dispatch:beforeException', $dispatcher, $e);
            }
        }
        catch (\ReflectionException $e) {
            $eventsManager->fire('dispatch:beforeException', $dispatcher, $e);
        }
    });
    $dispatcher = new MvcDispatcher();
    $router = $di->get('router');
    $dispatcher->setEventsManager($eventsManager);
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    return $dispatcher;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir)
        ->setLayout('main')
        ->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_',
                'compileAlways' => true
            ));

            $compiler = $volt->getCompiler();

            $compiler->addFunction('_', function($resolvedArgs, $exprArgs) {
                    return '$this->translate->_(' . $resolvedArgs .')';
                })
                ->addFunction('acl_link', function($resolvedArgs, $exprArgs) use ($compiler) {
                    $parameters = $compiler->expression($exprArgs[0]['expr']);

                    if (isset($exprArgs[1])) {
                        $text = $compiler->expression($exprArgs[1]['expr']);
                    } else {
                        $text = 'null';
                    }
                    if (isset($exprArgs[2])) {
                        $args = $compiler->expression($exprArgs[2]['expr']);
                    } else {
                        $args = 'array()';
                    }

                    return "\Library\Acl\Link::make($parameters, $text, $args)";
                })
                ->addFunction('ceil', 'ceil')
                ->addFunction('floor', 'floor')
                ->addFilter('int', function ($resolvedArgs, $exprArgs) {
                    return 'intval(' . $resolvedArgs . ')';
                })
                ->addFunction('start_js_buff', function($resolvedArgs, $exprArgs) {
                    return 'ob_start()';
                })
                ->addFunction('end_js_buff', function($resolvedArgs, $exprArgs) {
                    return '$this->assets->addInlineJs(preg_replace(\'/(<script.*?>)(.*)(<\/script>)/ims\', \'${2}\', ob_get_clean()))';
                });

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    $dbConfig = $config->database->toArray();
    $dbAdapterName = $dbConfig['adapter'];
    unset($dbConfig['adapter']);
    switch ($dbAdapterName) {
        case 'Postgresql':
            return new DbPdo\Postgresql($dbConfig);
            break;
        case 'Mysql':
            return new DbPdo\Mysql($dbConfig);
            break;
    }
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Flash service with custom CSS classes
 */
$di->set('flash', function () {
    return new Flash(array(
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ));
});

/**
 * Custom authentication component
 */
$di->set('auth', function () {
    return new \Library\Auth\Auth();
});

/**
 * Custom ACL component
 */
$di->set('acl', function() use($config) {
    $acl = new \Library\Acl\Adapter(array('aclDir' => $config->application->aclDir));
    // Default action is deny access
    $acl->setDefaultAction(Phalcon\Acl::DENY);
    return $acl;
});

/**
 * Translation component
 */
$di->set('translate', function() use($di, $config) {
    // Now we're getting the best language for the user
    $current_lang = $di->get('dispatcher')->getParam('lang', null, $di->get('request')->getBestLanguage());

    //Check if we have a translation file for that lang
    if (file_exists($config->application->messagesDir . $current_lang . '.php')) {
        $messages = require $config->application->messagesDir . $current_lang . '.php';
    } else {
        // fallback to some default
        $messages = require $config->application->messagesDir . 'en.php';
    }

    //Return a translation object
    return new \Phalcon\Translate\Adapter\NativeArray(array(
        "content" => $messages
    ));
});

/**
 * Custom Menu
 */
$di->set('menu', function() use($config) {
    $menu = require $config->application->menu;
    return $menu;
});

