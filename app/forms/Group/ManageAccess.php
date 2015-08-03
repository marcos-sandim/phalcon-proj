<?php
namespace App\Forms\Group;

use \Phalcon\Forms\Element\Check;
use \Phalcon\Forms\Element\Submit;

//use \Library\Forms\Decorator\Bootstrap as BootstrapDecorator;

class ManageAccess extends \Library\Forms\Base
{
    protected $_group;
    protected $_resources;

    public function __construct($group)
    {
        parent::__construct();

        $this->_group = $group;

        $this->setAction('/group/manage-access/' . $this->_group->id);

        $this->_viewScript = 'forms/group/manage-access';
        $this->_initForm();
    }

    private function _initForm()
    {
        $this->_resources = \App\Models\Resource::find(array('order' => 'name'));

        $currentAccess = array();
        foreach ($this->_group->GroupResource as $groupResource) {
            $currentAccess[$groupResource->resource_id] = $groupResource;
        }

        foreach ($this->_resources as $resource) {
            $element = new Check($resource->name, array(
                'value' => '1'
            ));
            if ($resource->is_public || array_key_exists($resource->id, $currentAccess) && $currentAccess[$resource->id]->allow) {
                $element->setAttribute('checked', 'checked');
            }
            if ($resource->is_public) {
                $element->setAttribute('disabled', 'disabled');
            }
            $this->add($element);
        }

        $element = new Submit('submit', array(
            'class' => 'btn btn-success pull-right'
        ));
        $element->setDefault($this->translate->_('GROUP MANAGE ACCESS FORM SUBMIT BUTTON LABEL'));
        $this->add($element);
    }

    public function getResources()
    {
        return $this->_resources;
    }
}
