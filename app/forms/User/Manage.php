<?php

namespace App\Forms\User;

use \Library\Forms\Base;
use \Phalcon\Forms\Element\Text;
//use \Phalcon\Forms\Element\Select;
use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf as PresenceOfValidador;
//use Phalcon\Validation\Validator\Identical as IdenticalValidador;
use Phalcon\Validation\Validator\StringLength as StringLengthValidador;
use Phalcon\Validation\Validator\Confirmation as ConfirmationValidador;

class Manage extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this->_viewScript = 'forms/user/manage';
        $this->_initForm();
    }

    private function _initForm()
    {
        $element = new Text('name');
        $element->setLabel('Name')
            ->setAttribute('class', 'form-control')
            ->setAttribute('size', 30);
        $this->add($element);

        $element = new Text('email');
        $element->setLabel('Email')
            ->setAttribute('class', 'form-control')
            ->addValidator(new EmailValidator());
        $this->add($element);

        $element = new Text('role');
        $element->setLabel('Role')
            ->setAttribute('class', 'form-control')
            ->setAttribute('size', 30);
        $this->add($element);

        $element = new Text('phone');
        $element->setLabel('Phone')
            ->setAttribute('class', 'form-control')
            ->setAttribute('size', 30);
        $this->add($element);

        $element = new Password('password');

        $element->setLabel('Password')
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
            ->setAttribute('class', 'form-control');
        $this->add($element);

        // Confirm Password
        $element = new Password('confirmPassword');

        $element->setLabel('Confirm Password')
            ->addValidators(array(
                new PresenceOfValidador(array(
                    'message' => 'The confirmation password is required'
                ))
            ))
            ->setAttribute('class', 'form-control');
        $this->add($element);

        /*$this->add(new Text('telephone'));

        $this->add(new Select('telephoneType', array(
            'H' => 'Home',
            'C' => 'Cell'
        )));*/

         // Sign Up
        $element = new Submit('submit', array(
            'class' => 'btn btn-success pull-right'
        ));
        $element->setLabel('Sign up');
        $this->add($element);
    }

     /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }
}
