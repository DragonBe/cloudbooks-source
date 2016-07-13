<?php

namespace Cloudbooks\Test\Author\Model;

use Cloudbooks\Author\Model\AuthorTable;

class AuthorTableTest extends \PHPUnit_Framework_TestCase
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
     * @covers \Cloudbooks\Author\Model\AuthorTable::__construct
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::__construct
     */
    public function testPdoGatewayImplementsTableGatewayInterface()
    {
        $authorTable = new AuthorTable($this->pdoMock);
        $this->assertInstanceOf('\Cloudbooks\Common\Interfaces\TableGatewayInterface', $authorTable);
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorTable::__construct
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::__construct
     */
    public function testPdoGatewayExtendsTableAbstract()
    {
        $authorTable = new AuthorTable($this->pdoMock);
        $this->assertInstanceOf('\Cloudbooks\Common\Db\Table\TableAbstract', $authorTable);
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorTable::find
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::find
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindElementsById()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Foo Bar',
                'biography' => 'Foo Bar baz',
            ]
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $authorTable = new AuthorTable($this->pdoMock);
        $result = $authorTable->find(1);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorTable::fetchAll
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

        $authorTable = new AuthorTable($this->pdoMock);
        $result = $authorTable->fetchAll(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorTable::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindElementsByCondition()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Foo Bar',
                'biography' => 'Foo Bar baz',
            ]
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $authorTable = new AuthorTable($this->pdoMock);
        $result = $authorTable->fetchAll(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorTable::fetchRow
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

        $authorTable = new AuthorTable($this->pdoMock);
        $result = $authorTable->fetchRow(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorTable::fetchRow
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchRow
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindSingleRowByCondition()
    {
        $data = [
            'id' => 1,
            'name' => 'Foo Bar',
            'biography' => 'Foo Bar baz',
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetch')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $authorTable = new AuthorTable($this->pdoMock);
        $result = $authorTable->fetchRow(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorTable::insert
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::insert
     */
    public function testGatewayCanInsertSingleRowData()
    {
        $data = [
            'id' => 1,
            'name' => 'Foo Bar',
            'biography' => 'Foo Bar baz',
        ];
        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);
        $this->pdoMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        $authorTable = new AuthorTable($this->pdoMock);
        $result = $authorTable->insert($data);
        $this->assertSame(1, $result);
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorTable::update
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::update
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanUpdateExistingRowData()
    {
        $data = [
            'id' => 1,
            'name' => 'Foo Bar',
            'biography' => 'Foo Bar baz',
        ];
        $this->pdoStmtMock
            ->expects($this->once())
            ->method('rowCount')
            ->willReturn(1);
        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $authorTable = new AuthorTable($this->pdoMock);
        $result = $authorTable->update($data, ['id = ?' => $data['id']]);
        $this->assertSame(1, $result);
    }
}