<?php

namespace Cloudbooks\Common\Db\Table;

use Cloudbooks\Common\Interfaces\TableGatewayInterface;

abstract class TableAbstract implements TableGatewayInterface
{
    protected $tableName;
    protected $primary;
    protected $schema;

    protected function assembleWhere(array $where): string
    {
        $conditions = array_keys($where);
        return 'WHERE (' . implode(') AND (', $conditions) . ')';
    }
}