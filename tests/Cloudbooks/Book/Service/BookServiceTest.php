<?php

namespace Cloudbooks\Test\Book\Service;

use Cloudbooks\Book\Service\BookService;

class BookServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Cloudbooks\Book\Service\BookService::__construct
     * @expectedException \TypeError
     */
    public function testBookServiceRequiresArgumentsForConstruct()
    {
        $bookService = new BookService();
        $this->fail('Constructor requires arguments in constructor');
    }

    /**
     * @covers Cloudbooks\Book\Service\BookService::__construct
     * @expectedException \TypeError
     */
    public function testBookServiceThrowsExceptionForWrongTypeOfArguments()
    {
        $tabelGatewayMock = $this->getMockBuilder('\stdClass')->getMock();
        $hydratorMock = $this->getMockBuilder('\stdClass')->getMock();
        $bookEntityMock = $this->getMockBuilder('\stdClass')->getMock();
        $bookService = new BookService($tabelGatewayMock, $hydratorMock, $bookEntityMock);
        $this->fail('Constructor requires correct arguments in constructor');
    }

    /**
     * @covers Cloudbooks\Book\Service\BookService::__construct
     */
    public function testBookServiceRequiresCorrectInterfaceArgumentsForConstruct()
    {
        $tabelGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $bookEntityMock = $this->getMockBuilder('\Cloudbooks\Book\Interfaces\BookInterface')->getMock();
        $bookService = new BookService($tabelGatewayMock, $hydratorMock, $bookEntityMock);
        return $bookService;
    }

    /**
     * @covers Cloudbooks\Book\Service\BookService::__construct
     * @covers Cloudbooks\Book\Service\BookService::listBooks
     */
    public function testBookServiceListsBooks()
    {
        $bookEntityMock = $this->getMockBuilder('\Cloudbooks\Book\Interfaces\BookInterface')->getMock();

        $fixture = [$bookEntityMock];

        $tabelGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $tabelGatewayMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($fixture);

        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();

        $bookService = new BookService($tabelGatewayMock, $hydratorMock, $bookEntityMock);
        $bookList = $bookService->listBooks(1);
        $this->assertCount(1, $bookList);
        $book = array_shift($bookList);
        $this->assertInstanceOf('\Cloudbooks\Book\Interfaces\BookInterface', $book);
    }

    /**
     * @covers Cloudbooks\Book\Service\BookService::__construct
     * @covers Cloudbooks\Book\Service\BookService::getBook
     */
    public function testBookServiceDetailsSingleBook()
    {
        $data = [
            'id' => 1,
            'title' => 'Foo',
            'abstract' => 'Foo bar baz foo-bar',
            'isbn' => '0123456789012',
            'member_id' => 1,
            'author_id' => 1,
        ];
        $bookEntityMock = $this->getMockBuilder('\Cloudbooks\Book\Interfaces\BookInterface')->getMock();

        $tabelGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $tabelGatewayMock->expects($this->once())
            ->method('fetchRow')
            ->willReturn($data);

        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->willReturn($bookEntityMock);

        $bookService = new BookService($tabelGatewayMock, $hydratorMock, $bookEntityMock);
        $book = $bookService->getBook(1, 1);
        $this->assertInstanceOf('\Cloudbooks\Book\Interfaces\BookInterface', $book);
    }

    /**
     * @covers Cloudbooks\Book\Service\BookService::__construct
     * @covers Cloudbooks\Book\Service\BookService::addBook
     */
    public function testBookServiceAddingSingleBook()
    {
        $data = [
            'id'        => 0,
            'title'     => 'Foo',
            'abstract'  => 'Foo bar baz foo-bar',
            'isbn'      => '01234567890123',
            'member_id' => 1,
            'author_id' => 1,
        ];

        $bookEntityMock = $this->getMockBuilder('\Cloudbooks\Book\Interfaces\BookInterface')
            ->setMethods(['getId', 'getTitle', 'getAbstract', 'getIsbn', 'getMemberId', 'getAuthorId', 'setId'])
            ->getMock();

        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $hydratorMock->expects($this->once())
            ->method('extract')
            ->willReturn($data);

        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $tableGatewayMock->expects($this->once())
            ->method('insert')
            ->willReturn(1);

        $bookService = new BookService($tableGatewayMock, $hydratorMock, $bookEntityMock);
        $result = $bookService->addBook($bookEntityMock);
        $this->assertInstanceOf('\Cloudbooks\Book\Interfaces\BookInterface', $result);
    }

    /**
     * @covers Cloudbooks\Book\Service\BookService::__construct
     * @covers Cloudbooks\Book\Service\BookService::updateBook
     * @expectedException \InvalidArgumentException
     */
    public function testBookServiceUpdatingSingleBookThrowsExceptionWhenIdNotAvailable()
    {
        $bookEntityMock = $this->getMockBuilder('\Cloudbooks\Book\Interfaces\BookInterface')->getMock();
        $bookEntityMock->expects($this->once())
            ->method('getId')
            ->willReturn(0);

        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();

        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();

        $bookService = new BookService($tableGatewayMock, $hydratorMock, $bookEntityMock);
        $result = $bookService->updateBook($bookEntityMock);
        $this->fail('Expected exception regarding invalid ID was not thrown');
    }

    /**
     * @covers Cloudbooks\Book\Service\BookService::__construct
     * @covers Cloudbooks\Book\Service\BookService::updateBook
     */
    public function testBookServiceUpdateingSingleBook()
    {
        $data = [
            'id'        => 1,
            'title'     => 'Foo',
            'abstract'  => 'Foo bar baz foo-bar',
            'isbn'      => '01234567890123',
            'member_id' => 1,
            'author_id' => 1,
        ];

        $bookEntityMock = $this->getMockBuilder('\Cloudbooks\Book\Interfaces\BookInterface')->getMock();
        $bookEntityMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $hydratorMock->expects($this->once())
            ->method('extract')
            ->willReturn($data);

        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $tableGatewayMock->expects($this->once())
            ->method('update')
            ->willReturn(1);

        $bookService = new BookService($tableGatewayMock, $hydratorMock, $bookEntityMock);
        $result = $bookService->updateBook($bookEntityMock);
        $this->assertInstanceOf('\Cloudbooks\Book\Interfaces\BookInterface', $result);
    }
}