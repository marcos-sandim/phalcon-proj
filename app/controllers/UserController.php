<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;

/**
 * User controller
 *
 * @AclName("APP ACL USER CONTROLLER NAME")
 * @AclDesc("APP ACL USER CONTROLLER DESC")
 */
class UserController extends \Library\Acl\ControllerBase
{

    /**
     * User index actio
     *
     * @AclName("APP ACL USER INDEX ACTION NAME")
     * @AclDesc("APP ACL USER INDEX ACTION DESC")
     */
    public function indexAction()
    {
        //$this->persistent->parameters = null;
        $this->view->page_title = 'USER LIST TITLE';
        $numberPage = $this->request->getQuery("page", "int");
        /*if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "User", $_POST);
            $this->persistent->parameters = $query->getParams();
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }*/

        $builder = $this->modelsManager->createBuilder()
                   ->columns(array('u.id', 'u.name', 'u.email', 'u.role', 'u.phone', 'u.active'))
                   ->from(array('u' => '\App\Models\User'))
                   ->orderBy(array('u.active DESC', 'u.name'));

        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $builder,
            "limit"=> 20,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a new user
     *
     * @AclName("APP ACL USER CREATE ACTION NAME")
     * @AclDesc("APP ACL USER CREATE ACTION DESC")
     */
    public function createAction()
    {
        $form = new App\Forms\User\Manage();
        $request = $this->request;
        $this->view->page_title = 'USER CREATE TITLE';

        if ($request->isPost()) {
            $data = $request->getPost();

            if ($form->isValid($data)) {
                $user = new App\Models\User();

                $salt = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                $cryptHash = sha1($data["password"] . $salt);

                $user->name = $data["name"];
                $user->email = $data["email"];
                $user->role = $data["role"];
                $user->phone = $data["phone"];
                $user->crypt_hash = $cryptHash;
                $user->password_salt = $salt;
                $user->active = true;

                if ($user->save()) {
                    $this->flash->success("user was created successfully");

                    return $this->response->redirect('/user');
                }
                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Edits a user
     *
     * @AclName("APP ACL USER EDIT ACTION NAME")
     * @AclDesc("APP ACL USER EDIT ACTION DESC")
     */
    public function editAction($id)
    {
        $user = \App\Models\User::findFirstById($id);
        $form = new App\Forms\User\Manage($user);
        $request = $this->request;
        $this->view->page_title = 'USER EDIT TITLE';

        if ($request->isPost()) {
            $data = $request->getPost();

            if ($form->isValid($data)) {
                $user->name = $data["name"];
                $user->email = $data["email"];
                $user->role = $data["role"];
                $user->phone = $data["phone"];

                if ($user->save()) {
                    $this->flash->success("user was edited successfully");

                    return $this->response->redirect('/user');
                }
                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Changes a user's password
     *
     * @AclName("APP ACL USER CHANGE PASSWORD ACTION NAME")
     * @AclDesc("APP ACL USER CHANGE PASSWORD ACTION DESC")
     */
    public function changePasswordAction()
    {
        $identity = $this->auth->getIdentity();
        $user = \App\Models\User::findFirstById($identity['id']);

        $this->view->page_title = 'USER CHANGE PASSWORD TITLE';
        $form = new App\Forms\User\ChangePassword($user);
        $request = $this->request;

        if ($request->isPost()) {
            $data = $request->getPost();

            if ($form->isValid($data)) {
                $salt = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                $cryptHash = sha1($data["password"] . $salt);

                $user->crypt_hash = $cryptHash;
                $user->password_salt = $salt;

                if ($user->save()) {
                    $this->flash->success("user was edited successfully");

                    return $this->response->redirect('/user');
                }
                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Deactivate a user
     *
     * @AclName("APP ACL USER DEACTIVATE ACTION NAME")
     * @AclDesc("APP ACL USER DEACTIVATE ACTION DESC")
     */
    public function deactivateAction($id)
    {
        $user = \App\Models\User::findFirstByid($id);
        if (!$user) {
            $this->flash->error($this->translate->_('USER DEACTIVATE NOT FOUND ERROR MESSAGE'));
            return $this->response->redirect('/user');
        }

        $user->active = false;
        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->response->redirect('/user');
        }

        $this->flash->success($this->translate->_('USER DEACTIVATE SUCCESS MESSAGE'));

        return $this->response->redirect('/user');
    }

    /**
     * Reactivate a user
     *
     * @AclName("APP ACL USER REACTIVATE ACTION NAME")
     * @AclDesc("APP ACL USER REACTIVATE ACTION DESC")
     */
    public function reactivateAction($id)
    {
        $user = \App\Models\User::findFirstByid($id);
        if (!$user) {
            $this->flash->error($this->translate->_('USER REACTIVATE NOT FOUND ERROR MESSAGE'));
            return $this->response->redirect('/user');
        }

        $user->active = true;
        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->response->redirect('/user');
        }

        $this->flash->success($this->translate->_('USER REACTIVATE SUCCESS MESSAGE'));

        return $this->response->redirect('/user');
    }

}
