<?php
namespace Library\Model;

class Base extends \Phalcon\Mvc\Model
{
    public function beforeValidationOnCreate()
    {
        if (is_null($this->created_at)) { // use default value if the value is not set
            $this->created_at = new \Phalcon\Db\RawValue('default');
        }
    }

    public function beforeValidationOnUpdate()
    {
        if (is_null($this->updated_at)) { // use default value if the value is not set
            $this->updated_at = date('Y-m-d H:i:s.u');
        }
    }
}