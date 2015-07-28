<?php
namespace App\Forms\User;

use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf as PresenceOfValidador;
//use Phalcon\Validation\Validator\Identical as IdenticalValidador;
use Phalcon\Validation\Validator\StringLength as StringLengthValidador;
use Phalcon\Validation\Validator\Confirmation as ConfirmationValidador;

use \Library\Forms\Decorator\Bootstrap as BootstrapDecorator;

class ChangePassword extends \Library\Forms\Base
{
    protected $_user;

    public function __construct($user = null)
    {
        parent::__construct();

        $this->_user = $user;
        $this->setAction('/user/changepassword');

        $this->_viewScript = 'forms/user/changepassword';
        $this->_initForm();
    }

    private function _initForm()
    {
        $element = new Password('password');
        $element->setLabel($this->translate->_('USER MANAGE FORM PASSWORD LABEL'))
            ->addValidators(array(
                new PresenceOfValidador(array(
                    'message' => 'The password is required'
                )),
                new StringLengthValidador(array(
                    'min' => 8,
                    'messageMinimum' => 'Password is too short. Minimum 8 characters'
                )),
                new ConfirmationValidador(array(
                    'message' => 'Password doesn\'t match confirmation',
                    'with' => 'confirmPassword'
                ))
            ))
            ->setAttribute('class', 'form-control')
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)));
        $this->add($element);

        // Confirm Password
        $element = new Password('confirmPassword');
        $element->setLabel($this->translate->_('USER MANAGE FORM CONFIRM PASSWORD LABEL'))
            ->addValidators(array(
                new PresenceOfValidador(array(
                    'message' => 'The confirmation password is required'
                ))
            ))
            ->setAttribute('class', 'form-control')
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)));
        $this->add($element);

        $element = new Submit('submit', array(
            'class' => 'btn btn-success pull-right'
        ));
        $element->setDefault($this->translate->_('USER MANAGE FORM SUBMIT BUTTON LABEL'));
        $this->add($element);
    }
}
