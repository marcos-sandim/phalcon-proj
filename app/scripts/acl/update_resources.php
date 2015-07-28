<?php
try {
    error_reporting(E_ALL);

    define('APP_PATH', realpath('.'));

    /**
     * Read the configuration
     */
    $config = include APP_PATH . "/app/config/config.php";

    /**
     * Read auto-loader
     */
    include APP_PATH . "/app/config/loader.php";

    /**
     * Read services
     */
    include APP_PATH . "/app/config/services.php";

    $controllers = [];

    foreach (glob($config->application->controllersDir . '*Controller.php') as $controller) {
        $className = /*'YourNamespace\Controller\\' .*/ basename($controller, '.php');

        //Parse the annotations in a class
        $reader = new \Phalcon\Annotations\Reader();
        $parsing = $reader->parse($className);

        //Create the reflection
        $reflection = new \Phalcon\Annotations\Reflection($parsing);

        //Get the annotations in the class docblock
        $classAnnotations = $reflection->getClassAnnotations();

        $controllerName = \Phalcon\Text::uncamelize(substr($className, 0, -10));

        $controllers[$controllerName] = [];

        if ($classAnnotations
            && $classAnnotations->has('AclName')
            && $classAnnotations->has('AclDesc')) {
            $controllers[$controllerName] = array(
                'name' => $controllerName,
                'display_name' => $classAnnotations->get('AclName')->getArgument(0),
                'description' => $classAnnotations->get('AclDesc')->getArgument(0),
                'is_public' => $classAnnotations->has('AclPublic') ? $classAnnotations->get('AclPublic')->getArgument(0) : 'false',
                );
        }

        $methodsAnnotations = $reflection->getMethodsAnnotations();

        $methods = (new \ReflectionClass($className))->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            if (\Phalcon\Text::endsWith($method->name, 'Action')
                && array_key_exists($method->name, $methodsAnnotations)
                && $methodsAnnotations[$method->name]->has('AclName')
                && $methodsAnnotations[$method->name]->has('AclDesc')) {

                $resourceName = $controllerName . ':' . str_replace('_', '', \Phalcon\Text::uncamelize(substr($method->name, 0, -6)));
                $controllers[$resourceName] = array(
                    'name' => $resourceName,
                    'display_name' => $methodsAnnotations[$method->name]->get('AclName')->getArgument(0),
                    'description' => $methodsAnnotations[$method->name]->get('AclDesc')->getArgument(0),
                    'is_public' => $methodsAnnotations[$method->name]->has('AclPublic') ? $methodsAnnotations[$method->name]->get('AclPublic')->getArgument(0) : 'false',
                    );
            }
        }
    }

    $resources = \App\Models\Resource::find();
    $currentResources = [];

    foreach ($resources as $resource) {
        $currentResources[$resource->name] = $resource;
    }

    $toDeleteResources = array_diff_key($currentResources, $controllers);
    $toCreateResources = array_diff_key($controllers, $currentResources);
    $toUpdateResources = array_intersect_key($currentResources, $controllers);

    foreach ($toDeleteResources as $resource) {
        $resource->delete();
    }

    foreach ($toCreateResources as $resourceData) {
        $resource = new \App\Models\Resource();
        $resource->assign($resourceData);
        if (!$resource->save()) {
            foreach($resource->getMessages() as $message)
            echo $message."\n";
        }
    }

    foreach ($toUpdateResources as $resource) {
        $resource->assign($controllers[$resource->name]);
        if (!$resource->save()) {
            foreach($resource->getMessages() as $message)
            echo $message."\n";
        }
    }
} catch (\Exception $e) {
    echo $e->getMessage()."\n".$e->getTraceAsString();;
}

