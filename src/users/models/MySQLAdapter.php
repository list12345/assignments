<?php

namespace Users\Models;

/**
 * Class MySQLAdapter
 */
class MySQLAdapter implements AdapterInterface
{

    /** @var \PDO */
    protected $pdo;

    /**
     * MySQLAdapter constructor.
     */
    public function __construct()
    {
        try {
            $this->pdo = new \PDO("mysql:host=192.168.192.1;port=3306;dbname=testdb", 'root', 'mysqlpass');
        } catch (\PDOException $pe) {
            die ("Could not connect to the database testdb:" . $pe->getMessage());
        }
    }

    /**
     * @param int $id
     * @param string $tablename
     * @param string $class_name
     *
     * @return DBModel|null
     */
    public function find(int $id, string $tablename, string $class_name): ?DBModel
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $tablename . ' WHERE id=:id');
        $statement->execute([':id' => $id]);
        $model = $statement->fetchObject($class_name);

        return $model instanceof DBModel ? $model : null;
    }

    /**
     * @param DBModel $model
     * @param string $tablename
     *
     * @return bool
     */
    public function save(DBModel $model, string $tablename): bool
    {
        if (property_exists($model, 'id') && isset($model->id)) {
            // update
            $sql = 'UPDATE ' . $tablename . ' SET ' . $model->prepareAttributes() . ' WHERE id=' . $model->id;
            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute($model->getDBAttributes());
        } else {
            // insert
            $attr = $model->getDBAttributes();
            $keys = array_keys($attr);
            $fields = implode(',', $keys);
            $placeholders = str_repeat('?,', count($keys) - 1) . '?';
            $sql = 'INSERT INTO ' . $tablename . ' (' . $fields . ') VALUES (' . $placeholders . ')';
            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute(array_values($attr));
        }
    }

    /**
     * @param string $tablename
     *
     * @return array
     */
    public function findAll(string $tablename): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . $tablename);
        $statement->execute();

        return $statement->fetchAll();
    }
}