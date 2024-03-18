<?php

namespace Users\Validators;

/**
 *
 */
interface AValidatorInterface
{
    /**
     * @param \Users\Models\DBModel $model
     * @param array $rule
     *
     * @return bool
     */
    public function validate(\Users\Models\DBModel $model, array $rule): bool;
}