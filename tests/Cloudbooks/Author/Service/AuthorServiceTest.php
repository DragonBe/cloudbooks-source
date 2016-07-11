<?php

namespace Cloudbooks\Test\Author\Service;

use Cloudbooks\Author\Service\AuthorService;

class AuthorServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Cloudbooks\Author\Service\AuthorService::__construct
     * @expectedException \TypeError
     */
    public function testAuthorServiceThrowsErrorWhenNoArgumentsAreGiven()
    {
        $authorService = new AuthorService();
        $this->fail('Creation of this service should fail without arguments');
    }

    /**
     * @covers \Cloudbooks\Author\Service\AuthorService::__construct
     * @expectedException \TypeError
     */
    public function testAuthorServiceThrowsErrorWhenWrongArgumentsAreGiven()
    {
        $tableGatewayMock = $this->getMockBuilder('\stdClass')->getMock();
        $hydratorMock = $this->getMockBuilder('\stdClass')->getMock();
        $authorEntityMock = $this->getMockBuilder('\stdClass')->getMock();

        $authorService = new AuthorService($tableGatewayMock, $hydratorMock, $authorEntityMock);
        $this->fail('Creation of this service should fail with wrong arguments');
    }

    /**
     * @covers \Cloudbooks\Author\Service\AuthorService::__construct
     */
    public function testAuthorServiceReturnsServiceObject()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $authorEntityMock = $this->getMockBuilder('\Cloudbooks\Author\Interfaces\AuthorInterface')->getMock();

        $authorService = new AuthorService($tableGatewayMock, $hydratorMock, $authorEntityMock);
        $this->assertInstanceOf('\Cloudbooks\Author\Service\AuthorService', $authorService);
    }

    /**
     * @covers \Cloudbooks\Author\Service\AuthorService::__construct
     * @covers \Cloudbooks\Author\Service\AuthorService::listAuthors
     */
    public function testAuthorServiceListAuthors()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $authorEntityMock = $this->getMockBuilder('\Cloudbooks\Author\Interfaces\AuthorInterface')->getMock();
        
        $tableGatewayMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn([$authorEntityMock]);

        $authorService = new AuthorService($tableGatewayMock, $hydratorMock, $authorEntityMock);
        $authorsList = $authorService->listAuthors(1);
        $this->assertCount(1, $authorsList);
        $author = array_shift($authorsList);
        $this->assertInstanceOf('\Cloudbooks\Author\Interfaces\AuthorInterface', $author);
    }

    /**
     * @covers \Cloudbooks\Author\Service\AuthorService::__construct
     * @covers \Cloudbooks\Author\Service\AuthorService::getAuthor
     */
    public function testAuthorServiceListSingleAuthor()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $authorEntityMock = $this->getMockBuilder('\Cloudbooks\Author\Interfaces\AuthorInterface')->getMock();

        $tableGatewayMock->expects($this->once())
            ->method('fetchRow')
            ->willReturn([]);
        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->willReturn($authorEntityMock);

        $authorService = new AuthorService($tableGatewayMock, $hydratorMock, $authorEntityMock);
        $author = $authorService->getAuthor(1, 1);
        $this->assertInstanceOf('\Cloudbooks\Author\Interfaces\AuthorInterface', $author);
    }

    /**
     * @covers \Cloudbooks\Author\Service\AuthorService::__construct
     * @covers \Cloudbooks\Author\Service\AuthorService::addAuthor
     */
    public function testAuthorServiceAddsSingleAuthor()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $authorEntityMock = $this->getMockBuilder('\Cloudbooks\Author\Interfaces\AuthorInterface')
            ->setMethods(['getId', 'getName', 'getBiography', 'setId'])
            ->getMock();

        $tableGatewayMock->expects($this->once())
            ->method('insert')
            ->willReturn(1);

        $authorService = new AuthorService($tableGatewayMock, $hydratorMock, $authorEntityMock);
        $author = $authorService->addAuthor($authorEntityMock);
        $this->assertInstanceOf('\Cloudbooks\Author\Interfaces\AuthorInterface', $author);
    }

    /**
     * @covers \Cloudbooks\Author\Service\AuthorService::__construct
     * @covers \Cloudbooks\Author\Service\AuthorService::updateAuthor
     * @expectedException \InvalidArgumentException
     */
    public function testAuthorServiceUpdateAuthorWithInvalidIdThrowsException()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $authorEntityMock = $this->getMockBuilder('\Cloudbooks\Author\Interfaces\AuthorInterface')->getMock();

        $authorService = new AuthorService($tableGatewayMock, $hydratorMock, $authorEntityMock);
        $author = $authorService->updateAuthor($authorEntityMock);
        $this->fail('Expected exception was not thrown for updating an author entity with wrong ID');
    }

    /**
     * @covers \Cloudbooks\Author\Service\AuthorService::__construct
     * @covers \Cloudbooks\Author\Service\AuthorService::updateAuthor
     */
    public function testAuthorServiceUpdateAuthor()
    {
        $data = [
            'id' => 1,
            'name' => 'Foo Bar',
            'biography' => 'Foo Bar was born in the codebase as a tiny example string',
        ];
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $authorEntityMock = $this->getMockBuilder('\Cloudbooks\Author\Interfaces\AuthorInterface')->getMock();

        $tableGatewayMock->expects($this->once())
            ->method('update')
            ->willReturn(1);

        $hydratorMock->expects($this->once())
            ->method('extract')
            ->willReturn($data);

        $authorEntityMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $authorService = new AuthorService($tableGatewayMock, $hydratorMock, $authorEntityMock);
        $author = $authorService->updateAuthor($authorEntityMock);
        $this->assertSame(1, $author);
    }
}