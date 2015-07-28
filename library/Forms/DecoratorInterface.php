<?php
namespace Library\Forms;

interface DecoratorInterface
{
    public function render(\Phalcon\Forms\Element $element, $attributes = null);
}