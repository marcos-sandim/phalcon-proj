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

use \Library\Forms\Decorator\Bootstrap as BootstrapDecorator;

class Login extends \Library\Forms\Base
{
    public function __construct()
    {
        parent::__construct();

        $this->_viewScript = 'forms/session/login';
        $this->setAction('/session/login');
        $this->_initForm();
    }

    private function _initForm()
    {
        // Email
        $element = new Email('email', array(
            'placeholder' => $this->translate->_('SESSION LOGIN FORM EMAIL LABEL')
        ));
        $element->addValidators(array(
            new PresenceOf(array(
                'message' => 'FORM ERROR MESSAGE REQUIRED FIELD'
            )),
            new EmailValidator(array(
                'message' => 'FORM ERROR MESSAGE INVALID EMAIL'
            ))
        ))
        ->setAttribute('class', 'form-control')
        ->setUserOption('decorator',
            new \Library\Forms\Decorator\Bootstrap(array(
                'feedback' => '<span class="glyphicon glyphicon-envelope form-control-feedback"></span>',
                'style' => BootstrapDecorator::VERTICAL,
            )));
        $this->add($element);

        // Password
        $element = new Password('password', array(
            'placeholder' => $this->translate->_('SESSION LOGIN FORM PASSWORD LABEL')
        ));
        $element->addValidator(new PresenceOf(array(
            'message' => 'FORM ERROR MESSAGE REQUIRED FIELD'
        )))
        ->setAttribute('class', 'form-control')
        ->setUserOption('decorator',
            new \Library\Forms\Decorator\Bootstrap(array(
                'feedback' => '<span class="glyphicon glyphicon-lock form-control-feedback"></span>',
                'style' => BootstrapDecorator::VERTICAL,
        )));
        $this->add($element);

        // Remember
        $element = new Check('remember', array(
            'value' => 'yes'
        ));
        $element->setLabel($this->translate->_('SESSION LOGIN FORM REMEMBER ME LABEL'));
        $this->add($element);

        // CSRF
        $element = new Hidden('csrf');
        $element->addValidator(new Identical(array(
                'value' => $this->security->getSessionToken(),
                'message' => 'CSRF validation failed'
            )))
            ->setDefault($this->security->getSessionToken());
        $this->add($element);

        $element = new Submit('login', array(
            'class' => 'btn btn-primary btn-block btn-flat'
        ));
        $element->setDefault($this->translate->_('SESSION LOGIN FORM LOGIN BUTTON LABEL'));
        $this->add($element);
    }
}
