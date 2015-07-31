<?php
namespace Library\Acl;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    /**
     * Execute before the router so we can determine if this is a provate controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();
        $controllerName = strtolower(str_replace('_', '-', \Phalcon\Text::uncamelize($controllerName)));
        $actionName = strtolower(str_replace('_', '-', \Phalcon\Text::uncamelize($actionName)));

        // Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName) || $this->acl->isPrivate("$controllerName:$actionName")) {
            // Get the current identity
            $identity = $this->auth->getIdentity();

            $di = \Phalcon\DI::getDefault();
            $translate = $di->get('translate');

            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {
                $this->flash->error($translate->_('ACL ACCESS DENIED MESSAGE'));

                return $this->response->redirect('/');
            }

            if (!$this->acl->isAllowed($identity['id'], $controllerName, $actionName)) {

                $this->flash->error($translate->_('ACL ACCESS DENIED MESSAGE'));

                if ($this->acl->isAllowed($identity['id'], $controllerName, 'index')) {
                    return $this->response->redirect('/' . strtolower($controllerName));
                } else {
                    return $this->response->redirect('/');
                }

                return false;
            }
        }
        return true;
    }
}
