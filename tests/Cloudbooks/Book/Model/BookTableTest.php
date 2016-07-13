<?php

namespace Cloudbooks\Test\Book\Model;

use Cloudbooks\Book\Model\BookTable;

class BookTableTest extends \PHPUnit_Framework_TestCase
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
     * @covers \Cloudbooks\Book\Model\BookTable::__construct
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::__construct
     */
    public function testPdoGatewayImplementsTableGatewayInterface()
    {
        $bookTable = new BookTable($this->pdoMock);
        $this->assertInstanceOf('\Cloudbooks\Common\Interfaces\TableGatewayInterface', $bookTable);
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookTable::__construct
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::__construct
     */
    public function testPdoGatewayExtendsTableAbstract()
    {
        $bookTable = new BookTable($this->pdoMock);
        $this->assertInstanceOf('\Cloudbooks\Common\Db\Table\TableAbstract', $bookTable);
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookTable::find
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::find
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindElementsById()
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Foo Bar',
                'abstract' => 'Foo Bar baz',
                'isbn' => '01234567890123',
                'author_id' => 1,
                'member_id' => 1,
            ]
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $bookTable = new BookTable($this->pdoMock);
        $result = $bookTable->find(1);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookTable::fetchAll
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

        $bookTable = new BookTable($this->pdoMock);
        $result = $bookTable->fetchAll(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookTable::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchAll
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindElementsByCondition()
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Foo Bar',
                'abstract' => 'Foo Bar baz',
                'isbn' => '01234567890123',
                'author_id' => 1,
                'member_id' => 1,
            ]
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $bookTable = new BookTable($this->pdoMock);
        $result = $bookTable->fetchAll(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookTable::fetchRow
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

        $bookTable = new BookTable($this->pdoMock);
        $result = $bookTable->fetchRow(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookTable::fetchRow
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::fetchRow
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanFindSingleRowByCondition()
    {
        $data = [
            'id' => 1,
            'title' => 'Foo Bar',
            'abstract' => 'Foo Bar baz',
            'isbn' => '01234567890123',
            'author_id' => 1,
            'member_id' => 1,
        ];
        $this->pdoStmtMock->expects($this->once())
            ->method('fetch')
            ->willReturn($data);
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $bookTable = new BookTable($this->pdoMock);
        $result = $bookTable->fetchRow(['id = ?' => 1]);
        $this->assertSame($data, $result);
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookTable::insert
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::insert
     */
    public function testGatewayCanInsertSingleRowData()
    {
        $data = [
            'id' => 1,
            'title' => 'Foo Bar',
            'abstract' => 'Foo Bar baz',
            'isbn' => '01234567890123',
            'author_id' => 1,
            'member_id' => 1,
        ];
        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);
        $this->pdoMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        $bookTable = new BookTable($this->pdoMock);
        $result = $bookTable->insert($data);
        $this->assertSame(1, $result);
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookTable::update
     * @covers \Cloudbooks\Common\Db\Table\PdoTableGateway::update
     * @covers \Cloudbooks\Common\Db\Table\TableAbstract::assembleWhere
     */
    public function testGatewayCanUpdateExistingRowData()
    {
        $data = [
            'id' => 1,
            'title' => 'Foo Bar',
            'abstract' => 'Foo Bar baz',
            'isbn' => '01234567890123',
            'author_id' => 1,
            'member_id' => 1,
        ];
        $this->pdoStmtMock
            ->expects($this->once())
            ->method('rowCount')
            ->willReturn(1);
        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($this->pdoStmtMock);

        $bookTable = new BookTable($this->pdoMock);
        $result = $bookTable->update($data, ['id = ?' => $data['id']]);
        $this->assertSame(1, $result);
    }
}
