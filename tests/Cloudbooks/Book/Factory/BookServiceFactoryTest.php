<?php

namespace Cloudbooks\Test\Book\Factory;

use Cloudbooks\Book\Factory\BookServiceFactory;
use Cloudbooks\Common\Interfaces\ServiceFactoryInterface;

class BookServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryImplementsServiceFactoryInterface()
    {
        $bookServiceFactory = new BookServiceFactory();
        $this->assertInstanceOf('\Cloudbooks\Common\Interfaces\ServiceFactoryInterface', $bookServiceFactory);
        return $bookServiceFactory;
    }

    /**
     * @depends testFactoryImplementsServiceFactoryInterface
     * @covers \Cloudbooks\Book\Factory\BookServiceFactory::createService
     */
    public function testFactoryCanCreateService(ServiceFactoryInterface $bookServiceFactory)
    {
        // Let's create our mock objects first
        $tabelGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $bookEntityMock = $this->getMockBuilder('\Cloudbooks\Book\Interfaces\BookInterface')->getMock();
        $serviceLocatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ServiceLocatorInterface')->getMock();

        // As we're calling the "get" method 3 times, we offer an argument map for return values
        $valueMap = [
            ['\Cloudbooks\Book\Model\BookTable', $tabelGatewayMock],
            ['\Cloudbooks\Book\Model\BookHydrator', $hydratorMock],
            ['\Cloudbooks\Book\Entity\Book', $bookEntityMock],
        ];

        // The implementation of the behaviour
        $serviceLocatorMock->expects($this->exactly(3))
            ->method('get')
            ->will($this->returnValueMap($valueMap));

        // Our actual test
        $bookService = $bookServiceFactory->createService($serviceLocatorMock);
        $this->assertInstanceOf('\Cloudbooks\Book\Service\BookService', $bookService);
    }
}