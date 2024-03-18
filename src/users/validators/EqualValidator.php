<?php

namespace Users\Validators;

/**
 * Class EqualValidator
 * for string only
 *
 */
class EqualValidator implements AValidatorInterface
{

    /**
     * @param \Users\Models\DBModel $model
     * @param array $rule
     *
     * @return bool
     */
    public function validate(\Users\Models\DBModel $model, array $rule): bool
    {
        if (isset($rule[0]) && is_string($rule[0]) && isset($rule['compareAttribute']) && is_string($rule['compareAttribute'])) {
            $attributes = explode(',', $rule[0]);
            foreach ($attributes as $attribute) {
                $attribute = trim($attribute);
                if (property_exists($model, $attribute)) {
                    $value = $model->$attribute;
                    $compare_attr = $rule['compareAttribute'];
                    if (!is_string($value)) {
                        $model->addError($attribute, 'Attribute is not string');

                        return false;
                    } elseif ($value !== $model->$compare_attr) {
                        $model->addError($attribute, 'Attributes are not equal');

                        return false;
                    }
                } else {
                    $model->addError($attribute, 'Attribute does not exist');

                    return false;
                }
            }
        } else {
            //throw exception
        }

        return true;
    }
}