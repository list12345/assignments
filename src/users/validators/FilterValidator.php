<?php

namespace Users\Validators;

/**
 * Class FilterValidator
 */
class FilterValidator implements AValidatorInterface
{
    /**
     * @param \Users\Models\DBModel $model
     * @param array $rule
     *
     * @return bool
     */
    public function validate(\Users\Models\DBModel $model, array $rule): bool
    {
        if (isset($rule[0]) && is_string($rule[0]) && $rule['filter']) {
            $attributes = explode(',', $rule[0]);
            foreach ($attributes as $attribute) {
                $attribute = trim($attribute);
                if (property_exists($model, $attribute)) {
                    $value = $model->$attribute;
                    $value = call_user_func($rule['filter'], $value);
                    $model->$attribute = $value;
                } else {
                    $model->addError($attribute, 'Attribute does not exist');
                }
            }
        } else {
            //throw exception
        }

        return true;
    }
}