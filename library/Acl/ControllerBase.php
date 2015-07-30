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

        // Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName) || $this->acl->isPrivate("$controllerName:$actionName")) {
            // Get the current identity

            $identity = $this->auth->getIdentity();
            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {
                //$this->flash->notice('You don\'t have access to this module: private');

                return $this->response->redirect('/');
            }

            if (!$this->acl->isAllowed($identity['id'], $controllerName, $actionName)) {

                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

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
