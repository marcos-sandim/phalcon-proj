<?php
namespace App\Forms\User;

use \Phalcon\Forms\Element\Text;
//use \Phalcon\Forms\Element\Select;
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
            ->setDefault($this->_user ? $this->_user->name : null);
        $this->add($element);

        $element = new Text('email');
        $element->setLabel($this->translate->_('USER MANAGE FORM EMAIL LABEL'))
            ->setAttribute('class', 'form-control')
            ->addValidator(new EmailValidator())
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)))
            ->setDefault($this->_user ? $this->_user->email : null);
        $this->add($element);

        $element = new Text('role');
        $element->setLabel($this->translate->_('USER MANAGE FORM ROLE LABEL'))
            ->setAttribute('class', 'form-control')
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)))
            ->setDefault($this->_user ? $this->_user->role : null);
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
        /*$this->add(new Text('telephone'));

        $this->add(new Select('telephoneType', array(
            'H' => 'Home',
            'C' => 'Cell'
        )));*/

         // Sign Up
        $element = new Submit('submit', array(
            'class' => 'btn btn-success pull-right'
        ));
        $element->setDefault($this->translate->_('USER MANAGE FORM SUBMIT BUTTON LABEL'));
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
