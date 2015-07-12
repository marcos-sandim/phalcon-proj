<?php
namespace App\Forms\Session;

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Identical;

class Login extends \Library\Forms\Base
{
    public function __construct()
    {
        parent::__construct();

        $this->_viewScript = 'forms/session/login';
        $this->_initForm();
    }

    private function _initForm()
    {
        // Email
        $element = new Email('email', array(
            'placeholder' => 'Email',
            'class' => 'form-control'
        ));
        $element->addValidators(array(
                new PresenceOf(array(
                    'message' => 'The e-mail is required'
                )),
                new EmailValidator(array(
                    'message' => 'The e-mail is not valid'
                ))
            ));
        $this->add($element);

        // Password
        $element = new Password('password', array(
            'placeholder' => 'Password'
        ));
        $element->addValidator(new PresenceOf(array(
                'message' => 'The password is required'
            )))
            ->setAttribute('class', 'form-control');
        $this->add($element);

        // Remember
        $element = new Check('remember', array(
            'value' => 'yes'
        ));
        $element->setLabel('Remember me');
        $this->add($element);

        // CSRF
        $element = new Hidden('csrf');
        $element->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));
        $this->add($element);

        $element = new Submit('login', array(
            'class' => 'btn btn-success pull-right'
        ));
        $element->setLabel('Login');
        $this->add($element);
    }
}
