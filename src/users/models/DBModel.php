<?php

namespace Users\Models;

/**
 * Class DBModel
 */
class DBModel
{
    /** @var array */
    protected array $errors = [];
    /** @var string */
    public $scenario;
    /** @var DBComponent */
    protected static $db;

    /**
     * DBModel constructor.
     */
    public function __construct()
    {
        self::$db = DBComponent::$db;
        $this->scenario = null;
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '';
    }

    /**
     * @return array validation rules
     */
    public function validationRules(): array
    {
        return [];
    }

    /**
     * @param int $id
     *
     * @return DBModel|null
     */
    public function find(int $id): ?DBModel
    {
        return self::$db->getStorageAdapter()->find($id, $this->tableName(), get_class($this));
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    public function load(array $attributes): bool
    {
        if (!empty($attributes)) {
            foreach ($attributes as $attribute => $value) {
                if (property_exists($this, $attribute)) {
                    $this->$attribute = $value;
                } else {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $result = true;
        $rules = $this->validationRules();
        foreach ($rules as $rule) {
            if (isset($rule[1])) {
                $class = 'Users\\Validators' . '\\' . ucfirst($rule[1]) . 'Validator';
                if (class_exists($class)) {
                    if (!isset($rule['on']) || in_array($this->scenario, $rule['on'])) {
                        $result = $result && (new $class)->validate($this, $rule);
                    }
                } else {
                    // trow Exception
                }
            }
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        return self::$db->getStorageAdapter()->save($this, static::tableName());
    }

    /**
     * @return string
     */
    public function prepareAttributes()
    {
        $result = '';
        $attributes = $this->getDBAttributes();
        foreach ($attributes as $attribute => $value) {
            $result .= $attribute . '=:' . $attribute . ',';
        }

        return trim($result, ',');
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        $values = [];

        $class = new \ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        foreach ($names as $name) {
            $values[$name] = $this->$name;
        }

        return $values;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return self::$db->getStorageAdapter()->findAll($this->tableName());
    }

    /**
     * @return array
     */
    public function getDBAttributes(): array
    {
        return [];
    }

    /**
     * @param $attribute
     * @param $message
     *
     * @return void
     */
    public function addError($attribute, $message): void
    {
        $this->errors[$attribute] = $message;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $attribute
     *
     * @return string
     */
    public function getError(string $attribute): string
    {
        return $this->errors[$attribute] ?? '';
    }
}