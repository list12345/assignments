<?php

namespace Users\Validators;

/**
 * Class MatchValidator
 */
class MatchValidator implements AValidatorInterface
{
    /**
     * @param \Users\Models\DBModel $model
     * @param array $rule
     *
     * @return bool
     */
    public function validate(\Users\Models\DBModel $model, array $rule): bool
    {
        if (isset($rule[0]) && is_string($rule[0]) && $rule['pattern']) {
            $attributes = explode(',', $rule[0]);
            foreach ($attributes as $attribute) {
                $attribute = trim($attribute);
                if (property_exists($model, $attribute)) {
                    if (!preg_match($rule['pattern'], $model->$attribute)) {
                        $model->addError($attribute, 'Attribute is invalid');

                        return false;
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