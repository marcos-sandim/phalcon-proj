<?php
/**
 * Main error controller
 *
 * @AclName("APP ACL ERROR CONTROLLER NAME")
 * @AclDesc("APP ACL ERROR CONTROLLER DESC")
 * @AclPublic("true")
 */
class ErrorController extends \Library\Acl\ControllerBase
{
    /**
     * Main public action
     *
     * @AclName("APP ACL ERROR NOT FOUND ACTION NAME")
     * @AclDesc("APP ACL ERROR NOT FOUND ACTION DESC")
     * @AclPublic("true")
     */
    public function notFoundAction()
    {
        //$this->view->setLayout('public');
    }

}

