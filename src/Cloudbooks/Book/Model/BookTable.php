<?php

namespace Cloudbooks\Book\Model;

use Cloudbooks\Common\Db\Table\PdoTableGateway;

class BookTable extends PdoTableGateway
{
    protected $tableName = 'book';
}
