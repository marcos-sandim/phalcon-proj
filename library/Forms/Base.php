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

    public function renderDecorated($name, $attributes = null)
    {
        $decorator = $this->_elements[$name]->getUserOption('decorator');

        if (is_string($decorator)) {
            $decorator = new $decorator();
        }

        if (!$decorator) {
            throw new \Phalcon\Forms\Exception("Invalid decorator given");
        }

        return $decorator->render($this->_elements[$name], $attributes);
    }
}

