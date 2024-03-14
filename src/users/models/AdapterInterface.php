<?php

namespace Users\Models;

/**
 *
 */
interface AdapterInterface {

    /**
     * @param int $id
     * @param string $tablename
     * @param string $class_name
     *
     * @return mixed
     */
    public function find(int $id, string $tablename, string $class_name);

    /**
     * @param DBModel $model
     * @param string $tablename
     *
     * @return bool
     */
    public function save(DBModel $model, string $tablename): bool;
}