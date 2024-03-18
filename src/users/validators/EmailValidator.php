<?php

namespace Users\Validators;

/**
 * Class EmailValidator
 * for simple email pattern
 */
class EmailValidator implements AValidatorInterface
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
                    $value = $model->$attribute;
                    if (!is_string($value)) {
                        $model->addError($attribute, 'Attribute is not string');

                        return false;
                    } elseif (!preg_match(
                        '/^(?P<name>(?:"?([^"]*)"?\s)?)(?:\s+)?(?:(?P<open><?)((?P<local>.+)@(?P<domain>[^>]+))(?P<close>>?))$/i',
                        $value,
                        $matches
                    )
                    ) {
                        $model->addError($attribute, 'Attribute is invalid');

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