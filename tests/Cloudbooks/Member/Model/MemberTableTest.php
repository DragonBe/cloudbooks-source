<?php

namespace Cloudbooks\Test\Member\Model;

use Cloudbooks\Member\Model\MemberTable;

class MemberTableTest extends \PHPUnit_Framework_TestCase
{
    protected $pdoMock;
    protected $pdoStmtMock;

    protected function setUp()
    {
        parent::setUp();
        $this->pdoMock = $this->getMockBuilder('\PDO')
            ->setConstructorArgs(['sqlite::memory:', 'foo', 'bar'])
            ->getMock();
        $this->pdoStmtMock = $this->getMockBuilder('\PDOStatement')->getMock();
    }

    protected function tearDown()
    {
        $this->pdoStmtMock = null;
        $this->pdoMock = null;
        parent::tearDown();
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::__construct
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::__construct
     */
    public function testPdoGatewayImplementsTableGatewayInterface()
    {
        $memberTable = new MemberTable($this->pdoMock);
        $this->assertInstanceOf('\Cloudbooks\Common\Interfaces\TableGatewayInterface', $memberTable);
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::__construct
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::__construct
     */
    public function testPdoGatewayExtendsTableAbstract()
    {
        $memberTable = new MemberTable($this->pdoMock);
        $this->assertInstanceOf('\Cloudbooks\Common\Db\Table\TableAbstract', $memberTable);
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::find
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::find
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindElementsById()
    {
        $data = [
            [
                'id' => 1,
                'email' => 'foo@bar.baz',
                'name' => 'Foo Bar',
                'password' => 'FooBarB@Z!',
            ]
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $memberTable = new MemberTable($this->pdoMock);
        $result = $memberTable->find(1);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanNotFindElementsByCondition()
    {
        $data = [];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn(false);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $memberTable = new MemberTable($this->pdoMock);
        $result = $memberTable->fetchAll(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindElementsByCondition()
    {
        $data = [
            [
                'id' => 1,
                'email' => 'foo@bar.baz',
                'name' => 'Foo Bar',
                'password' => 'FooBarB@Z!',
            ]
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $memberTable = new MemberTable($this->pdoMock);
        $result = $memberTable->fetchAll(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::fetchRow
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchRow
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanNotFindSingleRowByCondition()
    {
        $data = [];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetch')
            ->willReturn(false);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $memberTable = new MemberTable($this->pdoMock);
        $result = $memberTable->fetchRow(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::fetchRow
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchRow
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindSingleRowByCondition()
    {
        $data = [
            'id' => 1,
            'email' => 'foo@bar.baz',
            'name' => 'Foo Bar',
            'password' => 'FooBarB@Z!',
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetch')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $memberTable = new MemberTable($this->pdoMock);
        $result = $memberTable->fetchRow(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::insert
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::insert
     */
    public function testGatewayCanInsertSingleRowData()
    {
        $data = [
            'id' => 1,
            'email' => 'foo@bar.baz',
            'name' => 'Foo Bar',
            'password' => 'FooBarB@Z!',
        ];
        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);
        $this->pdoMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        $memberTable = new MemberTable($this->pdoMock);
        $result = $memberTable->insert($data);
        $this->assertSame(1, $result);
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberTable::update
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::update
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanUpdateExistingRowData()
    {
        $data = [
            'id' => 1,
            'email' => 'foo@bar.baz',
            'name' => 'Foo Bar',
            'password' => 'FooBarB@Z!',
        ];
        $this->pdoStmtMock
            ->expects($this->once())
            ->method('rowCount')
            ->willReturn(1);
        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $memberTable = new MemberTable($this->pdoMock);
        $result = $memberTable->update($data, ['id = ?' => $data['id']]);
        $this->assertSame(1, $result);
    }
}