<?php

namespace Users\Models;

/**
 * Class User
 */
class User extends DBModel
{
    /** @const STATE_NEW */
    const STATE_NEW = 0;
    /** @const STATE_ACTIVE */
    const STATE_ACTIVE = 1;
    /** @const STATE_BLOCKED */
    const STATE_BLOCKED = 2;
    /** @const STATE_DELETED */
    const STATE_DELETED = 3;
    /** @const SALT - used for password hash, it could be env */
    const SALT = '-salt';

    /** @var int */
    public $id;
    /** @var string email will be username */
    public $email;
    /** @var string */
    public $password;
    /** @var string */
    public $password1; // for new user registration
    /** @var string */
    public $password_hash; // to stored in db instead of password
    /** @var string */
    public $lastname;
    /** @var string */
    public $firstname;
    /** @var int */
    public $state;
    /** @var string */
    public $role; // if users can have multiple roles, more db tables need
    /** @var string */
    public $created_at;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'user';
    }

    /**
     * @return array validation rules
     */
    public function validationRules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [
                'password, password1, firstname, lastname, email',
                'filter',
                'filter' => 'trim',
            ],
            ['email', 'filter', 'filter' => 'mb_strtolower'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['password', 'match', 'pattern' => 'regExp'],
            ['password, firstname, lastname, email', 'length', 'max' => 128],
            ['password', 'length', 'min' => 8],
            ['password1', 'equal', 'compareAttribute' => 'password'],
            ['state', 'numerical', 'integerOnly' => true],
            ['firstname, lastname', 'TextFieldValidator', 'noHTML' => true],
            [
                'firstname, lastname',
                'safe',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getDBAttributes(): array
    {
        $result = [];
        $attributes = $this->getAttributes();

        foreach ($attributes as $attribute => $value) {
            if (in_array($attribute, ['email', 'password_hash', 'firstname', 'lastname', 'state', 'role',])) {
                $result[$attribute] = $value;
            }
        }

        return $result;
    }
}
