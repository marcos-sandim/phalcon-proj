<?php
namespace Library\Forms;

class Base extends \Phalcon\Forms\Form
{
    protected $_viewScript;

    public function __toString()
    {
        try {
            return $this->view->getPartial($this->_viewScript, array('element' => $this));
        }
        catch (\Exception $e) {
            var_dump($e); die;
            return '';
        }
    }
}

