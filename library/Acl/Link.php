<?php
namespace Library\Acl;

class Link
{
    public static function make($parameters, $text, $args)
    {
        $di = \Phalcon\DI::getDefault();
        $acl = $di->get('acl');
        $auth = $di->get('auth');
        $dispatcher = $di->get('dispatcher');
        $translate = $di->get('translate');

        if (array_key_exists('controller', $parameters)) {
            $controllerName = $parameters['controller'];
            $actionName = array_key_exists('action', $parameters) ? $parameters['action']  : null;
        } else {
            $controllerName = strtolower($dispatcher->getControllerName());
            $actionName = strtolower($dispatcher->getActionName());
            $controllerName = strtolower(str_replace('_', '-', \Phalcon\Text::uncamelize($controllerName)));
            $actionName = strtolower(str_replace('_', '-', \Phalcon\Text::uncamelize($actionName)));
        }
        $alwaysShow = array_key_exists('show', $args) && $args['show'] ? true : false;

        $getStrParams = array_key_exists('GET', $parameters) ? $parameters['GET'] : array();
        unset($parameters['controller']);
        unset($parameters['action']);
        unset($parameters['GET']);
        unset($args['show']);

        $allowed = true;

        // Only check permissions on private controllers
        if ($acl->isPrivate($controllerName)) {
            // Get the current identity
            $identity = $auth->getIdentity();

            // If there is no identity available
            if (!is_array($identity) || !$acl->isAllowed($identity['id'], $controllerName, $actionName, $parameters)) {
                $allowed = false;
            }
        }
        if ($allowed) {
            $paramsStr = '';
            $getStr = '';
            if (count($parameters)) {
                $paramsStr = '/' . implode('/', array_map(function ($item) { return urlencode($item); }, $parameters));
            }
            if (count($getStrParams)) {
                $getStr = '?' . implode('&', array_map(function ($k, $v) { return urlencode($k) . '=' . urlencode($v); }, array_keys($getStrParams), array_values($getStrParams)));
            }
            $text = $translate->_((string)$text);
            return \Phalcon\Tag::linkTo(array("/$controllerName/$actionName" . $paramsStr . $getStr, $text, true) + $args);
        }
        elseif ($alwaysShow) {
            $text = $text ? : $parameters[0];
            $text = $translate->_((string)$text);
            return \Phalcon\Tag::tagHtml('span', $parameters, false, true, false) . $text . \Phalcon\Tag::tagHtml('span', false);
        }
        return '';
    }
}