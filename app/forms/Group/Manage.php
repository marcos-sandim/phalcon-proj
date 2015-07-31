<?php
namespace App\Forms\Group;

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Check;
use \Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf as PresenceOfValidador;
use Phalcon\Validation\Validator\StringLength as StringLengthValidador;

use \Library\Forms\Decorator\Bootstrap as BootstrapDecorator;

class Manage extends \Library\Forms\Base
{
    protected $_group;

    public function __construct($group = null)
    {
        parent::__construct();

        $this->_group = $group;

        if ($this->_group) {
            $this->setAction('/group/edit/' . $this->_group->id);
        } else {
            $this->setAction('/group/create');
        }

        $this->_viewScript = 'forms/group/manage';
        $this->_initForm();
    }

    private function _initForm()
    {
        $element = new Text('name');
        $element->setLabel($this->translate->_('GROUP MANAGE FORM NAME LABEL'))
            ->setAttribute('class', 'form-control')
            ->setUserOption('decorator', new BootstrapDecorator(array('style' => BootstrapDecorator::VERTICAL)))
            ->setDefault($this->_group ? $this->_group->name : null);
        $this->add($element);

        $element = new Check('is_admin', array(
            'value' => '1'
        ));
        $element->setLabel($this->translate->_('GROUP MANAGE FORM IS ADMIN LABEL'));
        if ($this->_group && $this->_group->is_admin) {
            $element->setAttribute('checked', 'checked');
        }
        $this->add($element);

        $element = new Submit('submit', array(
            'class' => 'btn btn-success pull-right'
        ));
        $element->setDefault($this->translate->_('GROUP MANAGE FORM SUBMIT BUTTON LABEL'));
        $this->add($element);
    }
}
