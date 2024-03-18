<?php

namespace Users\Validators;

/**
 * Class RequiredValidator
 */
class RequiredValidator implements AValidatorInterface
{
    /**
     * @param \Users\Models\DBModel $model
     * @param array $rule
     *
     * @return bool
     */
    public function validate(\Users\Models\DBModel $model, array $rule): bool
    {
        if (isset($rule[0]) && is_string($rule[0])) {
            $attributes = explode(',', $rule[0]);
            foreach ($attributes as $attribute) {
                $attribute = trim($attribute);
                if (property_exists($model, $attribute)) {
                    if (empty($model->$attribute)) {
                        $model->addError($attribute, $attribute . ' is required');
                    }
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