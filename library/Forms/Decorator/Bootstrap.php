<?php
namespace Library\Forms\Decorator;

class Bootstrap implements \Library\Forms\DecoratorInterface
{
    const HORIZONTAL = 'form-horizontal';
    const VERTICAL = 'form-vertical';

    protected static $formStyles = array(
            self::HORIZONTAL,
            self::VERTICAL,
        );

    protected $_style = self::HORIZONTAL;
    protected $_feedback = null;

    public function __construct($options = array())
    {
        if (array_key_exists('style', $options) && in_array($options['style'], self::$formStyles)) {
            $this->_style = $options['style'];
        }

        if (array_key_exists('feedback', $options)) {
            $this->_feedback = $options['feedback'];
        }
    }

    public function render(\Phalcon\Forms\Element $element, $attributes = null)
    {
        $form = $element->getForm();
        $messages = $form->getMessagesFor($element->getName());

        $hasErrors = (bool) count($messages);
        $labelStyle = '';
        if ($this->_style == self::HORIZONTAL) {
            $labelStyle = 'col-sm-3';
        }

        $groupClass = '';
        if ($hasErrors) {
            $groupClass = ' has-error';
        }

        if ($this->_feedback) {
            $groupClass .= ' has-feedback';
        }

        $html = '<div class="form-group' . $groupClass . '">';
        if ($element->getLabel()) {
            $html .= $element->label(array('class' => "$labelStyle control-label"));
        }

        if ($this->_style == self::HORIZONTAL) {
            $html .= '<div class="col-sm-9">';
        }

        $html .= $element->render($attributes);

        $html .= (string) $this->_feedback;

        if (count($messages)) {
            $html .= '<div class="messages">';
            foreach ($messages as $message) {
                $html .= '<span class="help-block">' . $form->translate->_($message->__toString()) . '</span>';
            }
            $html .= '</div>';
        }

        if ($this->_style == self::HORIZONTAL) {
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }
}