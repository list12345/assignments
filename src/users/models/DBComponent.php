<?php

namespace Users\Models;

/**
 * Class DBComponent
 */
class DBComponent
{
    /** @var DBComponent */
    public static $db;
    /** @var AdapterInterface */
    public $storage_adapter;

    /**
     * @return AdapterInterface
     */
    public function getStorageAdapter(): AdapterInterface
    {
        return $this->storage_adapter;
    }

    /**
     * @param AdapterInterface $storage_adapter
     *
     * @return void
     */
    public function setStorageAdapter(AdapterInterface $storage_adapter): void
    {
        $this->storage_adapter = $storage_adapter;
    }
}