<?php
namespace App\Models;

use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class User extends \Library\Model\Base
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
    public $email;

    /**
     *
     * @var string
     */
    public $role;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $crypt_hash;

    /**
     *
     * @var string
     */
    public $picture;

    /**
     *
     * @var string
     */
    public $password_salt;

    /**
     *
     * @var string
     */
    public $active;

    /**
     *
     * @var string
     */
    public $forgot_password_hash;

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
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );

        $this->validate(new Uniqueness(array(
            'field' => 'email'
        )));

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema('public');
//        $this->hasMany('id', 'CmsPage', 'creator_id', array('alias' => 'CmsPage'));
//        $this->hasMany('id', 'TranslationComment', 'user_id', array('alias' => 'TranslationComment'));
//        $this->hasMany('id', 'TranslationLanguageUser', 'user_id', array('alias' => 'TranslationLanguageUser'));
//        $this->hasMany('id', 'TranslationValue', 'translator_id', array('alias' => 'TranslationValue'));
//        $this->hasMany('id', 'TranslationValue', 'approved_by_id', array('alias' => 'TranslationValue'));
        $this->hasMany('id', '\App\Models\UserGroup', 'user_id', array('alias' => 'UserGroup'));
        $this->hasManyToMany('id', '\App\Models\UserGroup', 'user_id', 'group_id', '\App\Models\Group','id', array('alias' => 'Group'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function setGroups($groups)
    {
        $currentGroups = array();
        $newGroups = array();

        foreach ($this->UserGroup as $userGroup) {
            $currentGroups[$userGroup->group_id] = $userGroup;
        }

        foreach ($groups as $group) {
            $newGroups[$group->id] = $group;
        }

        $toAdd = array_diff_key($newGroups, $currentGroups);
        $toRem = array_diff_key($currentGroups, $newGroups);

        foreach ($toAdd as $group) {
            $userGroup = new UserGroup();
            $userGroup->user_id = $this->id;
            $userGroup->group_id = $group->id;
            $userGroup->save();
        }

        foreach ($toRem as $userGroup) {
            $userGroup->delete();
        }
    }
}
