<?php

namespace Users\Models;

/**
 * Class DBModel
 */
class DBModel
{
    /** @var array */
    protected array $errors;
    /** @var AdapterInterface */
    protected $storage_adapter;

    /**
     * DBModel constructor.
     */
    public function __construct()
    {
        $this->storage_adapter = new MySQLAdapter();
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
        return $this->storage_adapter->find($id, $this->tableName(), get_class($this));
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
        $rules = $this->validationRules();
        foreach ($rules as $rule) {
            //create validator and validate field
            //if error then to add it to model's errors
        }

        return true;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        return $this->storage_adapter->save($this, static::tableName());
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
        return $this->storage_adapter->findAll($this->tableName());
    }

    /**
     * @return array
     */
    public function getDBAttributes(): array
    {
        return [];
    }
}