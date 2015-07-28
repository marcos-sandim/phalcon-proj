<?php
namespace App\Models;

class Resource extends \Library\Model\Base
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $display_name;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $is_public;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSchema("public");
        $this->hasMany('id', 'CmsMenuItem', 'resource_id', array('alias' => 'CmsMenuItem'));
        $this->hasMany('id', 'GroupResource', 'resource_id', array('alias' => 'GroupResource'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'resource';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Resource[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Resource
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
