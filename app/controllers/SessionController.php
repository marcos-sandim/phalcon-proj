<?php

/*use Vokuro\Forms\LoginForm;
use Vokuro\Forms\SignUpForm;
use Vokuro\Forms\ForgotPasswordForm;
use Vokuro\Auth\Exception as AuthException;
use Vokuro\Models\Users;
use Vokuro\Models\ResetPasswords;*/

/**
 * Controller used handle non-authenticated session actions like login/logout, user signup, and forgotten passwords
 *
 * @AclName("APP ACL SESSION CONTROLLER NAME")
 * @AclDesc("APP ACL SESSION CONTROLLER DESC")
 * @AclPublic("true")
 */
class SessionController extends \Library\Acl\ControllerBase
{

    /**
     * Initializer: Set the login layout (layouts/login.volt)
     */
    public function initialize()
    {
        $this->view->setLayout('login');
    }

    /**
     * Starts a session in the admin backend
     *
     * @AclName("APP ACL SESSION LOGIN ACTION NAME")
     * @AclDesc("APP ACL SESSION LOGIN ACTION DESC")
     * @AclPublic("true")
     */
    public function loginAction()
    {
        $form = new \App\Forms\Session\Login();
        $authOk =false;
        try {

            if ($this->request->isPost()) {
                if ($form->isValid($this->request->getPost())) {
                    $authOk = $this->auth->check(array(
                            'email' => $this->request->getPost('email'),
                            'password' => $this->request->getPost('password'),
                            'remember' => $this->request->getPost('remember')
                        ));
                }

                $form->get('password')->clear();
                if ($authOk) {
                    return $this->response->redirect('/user');
                } else {
                    $this->flash->error($this->translate->_('SESSION LOGIN INVALID PASSWORD MESSAGE'));
                }
            }
            else {
                if ($this->auth->hasRememberMe()) {
                    return $this->auth->loginWithRememberMe();
                }
            }
        } catch (\Library\Auth\Exception $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = $form;
    }

    /**
     * Shows the forgot password form
     *
     * @AclName("APP ACL SESSION FORGOT PASSWORD ACTION NAME")
     * @AclDesc("APP ACL SESSION FORGOT PASSWORD ACTION DESC")
     * @AclPublic("true")
     */
    public function forgotPasswordAction()
    {
        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = Users::findFirstByEmail($this->request->getPost('email'));
                if (!$user) {
                    $this->flash->success('There is no account associated to this email');
                } else {

                    $resetPassword = new ResetPasswords();
                    $resetPassword->usersId = $user->id;
                    if ($resetPassword->save()) {
                        $this->flash->success('Success! Please check your messages for an email reset password');
                    } else {
                        foreach ($resetPassword->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    }
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Closes the session
     *
     * @AclName("APP ACL SESSION LOGOUT ACTION NAME")
     * @AclDesc("APP ACL SESSION LOGOUT ACTION DESC")
     * @AclPublic("true")
     */
    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('/session/login');
    }
}
