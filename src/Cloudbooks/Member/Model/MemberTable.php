<?php

namespace Cloudbooks\Member\Model;

use Cloudbooks\Common\Db\Table\PdoTableGateway;

class MemberTable extends PdoTableGateway
{
    protected $tableName = 'member';
}
