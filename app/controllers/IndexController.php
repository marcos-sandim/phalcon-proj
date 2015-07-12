<?php

class IndexController extends \Library\Acl\ControllerBase
{

    public function indexAction()
    {
        $this->view->setLayout('public');
    }

}

