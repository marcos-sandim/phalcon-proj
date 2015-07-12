<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class UserController extends \Library\Acl\ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        //$this->persistent->parameters = null;

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "User", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "name";

        $user = \App\Models\User::find($parameters);
        if (count($user) == 0) {
            $this->flash->notice("The search did not find any user");

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $user,
            "limit"=> 20,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Edits a user
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $user = User::findFirstByid($id);
            if (!$user) {
                $this->flash->error("user was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "index"
                ));
            }

            $this->view->id = $user->id;

            $this->tag->setDefault("id", $user->id);
            $this->tag->setDefault("name", $user->name);
            $this->tag->setDefault("email", $user->email);
            $this->tag->setDefault("role", $user->role);
            $this->tag->setDefault("phone", $user->phone);
            $this->tag->setDefault("crypt_hash", $user->crypt_hash);
            $this->tag->setDefault("picture", $user->picture);
            $this->tag->setDefault("password_salt", $user->password_salt);
            $this->tag->setDefault("active", $user->active);
            $this->tag->setDefault("forgot_password_hash", $user->forgot_password_hash);
            $this->tag->setDefault("created_at", $user->created_at);
            $this->tag->setDefault("updated_at", $user->updated_at);

        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {
        $form = new App\Forms\User\Manage();
        $request = $this->request;

        if ($request->isPost()) {
            $data = $request->getPost();

            if ($form->isValid($data)) {
                $user = new App\Models\User();

                $salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
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

                    return $this->response->redirect('user');
                }
                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $user = User::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        $user->name = $this->request->getPost("name");
        $user->email = $this->request->getPost("email", "email");
        $user->role = $this->request->getPost("role");
        $user->phone = $this->request->getPost("phone");
        $user->crypt_hash = $this->request->getPost("crypt_hash");
        $user->picture = $this->request->getPost("picture");
        $user->password_salt = $this->request->getPost("password_salt");
        $user->active = $this->request->getPost("active");
        $user->forgot_password_hash = $this->request->getPost("forgot_password_hash");
        $user->created_at = $this->request->getPost("created_at");
        $user->updated_at = $this->request->getPost("updated_at");


        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "edit",
                "params" => array($user->id)
            ));
        }

        $this->flash->success("user was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "user",
            "action" => "index"
        ));

    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $user = User::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "index"
            ));
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "search"
            ));
        }

        $this->flash->success("user was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "user",
            "action" => "index"
        ));
    }

}
