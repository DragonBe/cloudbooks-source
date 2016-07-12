<?php

namespace Cloudbooks\Common\Db\Table;

class PdoTableGateway extends TableAbstract
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): array
    {
        return $this->fetchAll(['id = ?' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function fetchRow(array $where = [], array $order = []): array
    {
        $query = sprintf('SELECT * FROM `%s` ', $this->tableName);
        if ([] !== $where) {
            $query .= $this->assembleWhere($where);
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_values($where));
        if (false === ($resultRow = $stmt->fetch(\PDO::FETCH_ASSOC))) {
            return [];
        }
        return $resultRow;
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(array $where = [], array $order = [], int $count = 0, int $offset = 0): array
    {
        $query = sprintf('SELECT * FROM `%s` ', $this->tableName);
        if ([] !== $where) {
            $query .= $this->assembleWhere($where);
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_values($where));
        if (false === ($resultSet = $stmt->fetchAll(\PDO::FETCH_ASSOC))) {
            return [];
        }
        return $resultSet;
    }

    /**
     * @inheritDoc
     */
    public function insert(array $data): int
    {
        $fields = array_keys($data);
        $query = sprintf(
            'INSERT INTO `%s` (%s) VALUES (%s)',
            $this->tableName,
            implode(', ', $fields),
            array_fill(0, count($fields), '?')
        );
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_values($data));
        $id = (int) $this->pdo->lastInsertId();
        return $id;
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, array $where = []): int
    {
        $query = sprintf('UPDATE `%s` SET ', $this->tableName);
        $fields = [];
        foreach ($data as $key => $value) {
            $sql = sprintf('%s = ?', $key);
            $fields[$sql] = $value;
        }
        $query .= implode(', ', array_keys($fields));
        if ([] !== $where) {
            $query .= $this->assembleWhere($where);
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array_values($data));
        $id = (int) $stmt->rowCount();
        return $id;
    }

}