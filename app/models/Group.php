<?php
namespace App\Models;

class Group extends \Library\Model\Base
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
    public $is_admin;

    /**
     *
     * @var string
     */
    public $locked;

    /**
     *
     * @var string
     */
    public $active;

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
        //$this->hasMany('id', 'CmsMenuItemGroup', 'group_id', array('alias' => 'CmsMenuItemGroup'));
        //$this->hasMany('id', 'CmsPageGroup', 'group_id', array('alias' => 'CmsPageGroup'));
        //$this->hasMany('id', 'TranslationLanguageGroup', 'group_id', array('alias' => 'TranslationLanguageGroup'));
        $this->hasMany('id', '\App\Models\GroupResource', 'group_id', array('alias' => 'GroupResource'));
        $this->hasMany('id', '\App\Models\UserGroup', 'group_id', array('alias' => 'UserGroup'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'group';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Group[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    public static function findIn(array $identifiers)
    {
        return self::query()
            ->inWhere('id', $identifiers)
            ->execute();
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Group
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
