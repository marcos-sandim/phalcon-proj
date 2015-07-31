<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;

/**
 * Group controller
 *
 * @AclName("APP ACL GROUP CONTROLLER NAME")
 * @AclDesc("APP ACL GROUP CONTROLLER DESC")
 */
class GroupController extends \Library\Acl\ControllerBase
{

    /**
     * Group index actio
     *
     * @AclName("APP ACL GROUP INDEX ACTION NAME")
     * @AclDesc("APP ACL GROUP INDEX ACTION DESC")
     */
    public function indexAction()
    {
        $this->view->page_title = 'GROUP LIST TITLE';
        $numberPage = $this->request->getQuery("page", "int");

        $builder = $this->modelsManager->createBuilder()
                   ->columns(array('g.id', 'g.name', 'g.is_admin', 'g.active'))
                   ->from(array('g' => '\App\Models\Group'))
                   ->orderBy(array('g.active DESC', 'g.name'));

        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $builder,
            "limit"=> 20,
            "page" => $numberPage
        ));

        //$this->flash->success("Your information was stored correctly!");

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a new group
     *
     * @AclName("APP ACL GROUP CREATE ACTION NAME")
     * @AclDesc("APP ACL GROUP CREATE ACTION DESC")
     */
    public function createAction()
    {
        $form = new App\Forms\Group\Manage();
        $request = $this->request;
        $this->view->page_title = 'GROUP CREATE TITLE';

        if ($request->isPost()) {
            $data = $request->getPost();

            if ($form->isValid($data)) {
                $group = new App\Models\Group();

                $group->name = $data['name'];
                $group->is_admin = array_key_exists('is_admin', $data) && $data['is_admin'];
                $group->active = true;

                if ($group->save()) {
                    $this->flash->success('group was created successfully');

                    return $this->response->redirect('/group');
                }
                foreach ($group->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Edits a group
     *
     * @AclName("APP ACL GROUP EDIT ACTION NAME")
     * @AclDesc("APP ACL GROUP EDIT ACTION DESC")
     */
    public function editAction($id)
    {
        $group = \App\Models\Group::findFirstById($id);
        $form = new App\Forms\Group\Manage($group);
        $request = $this->request;
        $this->view->page_title = 'GROUP EDIT TITLE';

        if ($request->isPost()) {
            $data = $request->getPost();

            if ($form->isValid($data)) {
                $group->name = $data['name'];
                $group->is_admin = array_key_exists('is_admin', $data) && $data['is_admin'];

                if ($group->save()) {
                    $this->flash->success("group was edited successfully");

                    return $this->response->redirect('/group');
                }
                foreach ($group->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Deactivate a group
     *
     * @AclName("APP ACL GROUP DEACTIVATE ACTION NAME")
     * @AclDesc("APP ACL GROUP DEACTIVATE ACTION DESC")
     */
    public function deactivateAction($id)
    {
        $group = \App\Models\Group::findFirstByid($id);
        if (!$group) {
            $this->flash->error($this->translate->_('GROUP DEACTIVATE NOT FOUND ERROR MESSAGE'));
            return $this->response->redirect('/group');
        }

        $group->active = false;
        if (!$group->save()) {
            foreach ($group->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->response->redirect('/group');
        }

        $this->flash->success($this->translate->_('GROUP DEACTIVATE SUCCESS MESSAGE'));

        return $this->response->redirect('/group');
    }

    /**
     * Reactivate a group
     *
     * @AclName("APP ACL GROUP REACTIVATE ACTION NAME")
     * @AclDesc("APP ACL GROUP REACTIVATE ACTION DESC")
     */
    public function reactivateAction($id)
    {
        $group = \App\Models\Group::findFirstByid($id);
        if (!$group) {
            $this->flash->error($this->translate->_('GROUP REACTIVATE NOT FOUND ERROR MESSAGE'));
            return $this->response->redirect('/group');
        }

        $group->active = true;
        if (!$group->save()) {
            foreach ($group->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->response->redirect('/group');
        }

        $this->flash->success($this->translate->_('GROUP REACTIVATE SUCCESS MESSAGE'));

        return $this->response->redirect('/group');
    }

}
