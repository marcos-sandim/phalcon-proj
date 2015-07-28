<?php
/**
 * Main public controller
 *
 * @AclName("APP ACL INDEX CONTROLLER NAME")
 * @AclDesc("APP ACL INDEX CONTROLLER DESC")
 * @AclPublic("true")
 */
class IndexController extends \Library\Acl\ControllerBase
{
    /**
     * Main public action
     *
     * @AclName("APP ACL INDEX INDEX ACTION NAME")
     * @AclDesc("APP ACL INDEX INDEX ACTION DESC")
     * @AclPublic("true")
     */
    public function indexAction()
    {
        $this->view->setLayout('public');
    }

}

