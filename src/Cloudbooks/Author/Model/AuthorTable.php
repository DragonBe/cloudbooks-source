<?php

namespace Cloudbooks\Author\Model;

use Cloudbooks\Common\Db\Table\PdoTableGateway;

class AuthorTable extends PdoTableGateway
{
    protected $tableName = 'author';
}
