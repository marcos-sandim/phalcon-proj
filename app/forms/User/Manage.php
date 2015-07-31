<?php
namespace App\Forms\User;

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Select;
use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf as PresenceOfValidador;
//use Phalcon\Validation\Validator\Identical as IdenticalValidador;
use Phalcon\Validation\Validator\StringLength as StringLengthValidador;
use Phalcon\Validation\Validator\Confirmation as ConfirmationValidador;

use \Library\Forms\Decorator\Bootstrap as BootstrapDecorator;

class Manage extends \Library\Forms\Base
{
    protected $_user;

    public function __construct($user = null)
    {
        parent::__construct();

        $this->_user = $user;

        if ($this->_user) {
            $this->setAction('/user/edit/' . $this->_user->id);
        } else {
            $this->setAction('/user/create');
        }

        $this->_viewScript = 'forms/user/manage';
        $this->_initForm();
    }

    private function _initForm()
    {
        $element = new Text('name');
        $element->setLabel($this->translate->_('USER MANAGE FORM NAME LABEL'))
            ->setAttribute('class', 'form-control')
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)))
            ->setDefault($this->_user ? $this->_user->name : null)
            ->addValidators(array(
                new PresenceOfValidador(array(
                    'message' => 'FORM ERROR MESSAGE REQUIRED FIELD'
                )),
                new StringLengthValidador(array(
                    'max' => 256,
                    'messageMaximum' => $this->translate->_('FORM ERROR MESSAGE TOO LONG MESSAGE')
                ))));
        $this->add($element);

        $element = new Text('email');
        $element->setLabel($this->translate->_('USER MANAGE FORM EMAIL LABEL'))
            ->setAttribute('class', 'form-control')
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)))
            ->setDefault($this->_user ? $this->_user->email : null)
            ->addValidators(array(
                new PresenceOfValidador(array(
                    'message' => 'FORM ERROR MESSAGE REQUIRED FIELD'
                )),
                new StringLengthValidador(array(
                    'max' => 256,
                    'messageMaximum' => $this->translate->_('FORM ERROR MESSAGE TOO LONG MESSAGE')
                )),
                new EmailValidator()));
        $this->add($element);

        $element = new Text('role');
        $element->setLabel($this->translate->_('USER MANAGE FORM ROLE LABEL'))
            ->setAttribute('class', 'form-control')
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)))
            ->setDefault($this->_user ? $this->_user->role : null)
            ->addValidators(array(
                new PresenceOfValidador(array(
                    'message' => 'FORM ERROR MESSAGE REQUIRED FIELD'
                )),
                new StringLengthValidador(array(
                    'max' => 256,
                    'messageMaximum' => $this->translate->_('FORM ERROR MESSAGE TOO LONG MESSAGE')
                ))));
        $this->add($element);

        $element = new Text('phone');
        $element->setLabel($this->translate->_('USER MANAGE FORM PHONE LABEL'))
            ->setAttribute('class', 'form-control')
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)))
            ->setDefault($this->_user ? $this->_user->phone : null);
        $this->add($element);

        if (!$this->_user) {
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
        }

        $currentGroups = array();
        if ($this->_user) {
            foreach ($this->_user->Group as $group) {
                $currentGroups[] = $group->id;
            }
        }

        $element = new Select('groups', \App\Models\Group::findByActive(true), array('using' => array('id', 'name'), 'name' => 'groups[]'));
        $element->setLabel($this->translate->_('USER MANAGE FORM GROUPS LABEL'))
            ->setAttribute('class', 'form-control select2')
            ->setAttribute('multiple', 'multiple')
            ->setAttribute('data-placeholder', $this->translate->_('USER MANAGE FORM GROUPS PLACEHOLDER'))
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)))
            ->setDefault($currentGroups)
            ->addValidators(array(
                new PresenceOfValidador(array(
                    'message' => 'FORM ERROR MESSAGE REQUIRED FIELD'
                ))));
        $this->add($element);

         // Sign Up
        $element = new Submit('submit', array(
            'class' => 'btn btn-success pull-right'
        ));
        $element->setDefault($this->translate->_('USER MANAGE FORM SUBMIT BUTTON LABEL'));
        $this->add($element);
    }
}
