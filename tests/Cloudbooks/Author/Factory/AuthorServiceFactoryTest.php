<?php

namespace Cloudbooks\Test\Author\Factory;

use Cloudbooks\Author\Factory\AuthorServiceFactory;
use Cloudbooks\Common\Interfaces\ServiceFactoryInterface;

class AuthorServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceFactoryImplementsServiceFactoryInterface()
    {
        $authorServiceFactory = new AuthorServiceFactory();
        $this->assertInstanceOf('\Cloudbooks\Common\Interfaces\ServiceFactoryInterface', $authorServiceFactory);
        return $authorServiceFactory;
    }

    /**
     * @depends testServiceFactoryImplementsServiceFactoryInterface
     */
    public function testServiceFactoryCreatesService(ServiceFactoryInterface $authorServiceFactory)
    {
        // Create required mock objects
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $authorEntityMock = $this->getMockBuilder('\Cloudbooks\Author\Interfaces\AuthorInterface')->getMock();
        $serviceLocatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ServiceLocatorInterface')->getMock();

        // Create value map for the service locator
        $valueMap = [
            ['\Cloudbooks\Author\Model\AuthorTable', $tableGatewayMock],
            ['\Cloudbooks\Author\Model\AuthorHydrator', $hydratorMock],
            ['\Cloudbooks\Author\Entity\Author', $authorEntityMock],
        ];

        // Implement the logic for the stub
        $serviceLocatorMock->expects($this->exactly(3))
            ->method('get')
            ->will($this->returnValueMap($valueMap));

        // Run the test
        $authorService = $authorServiceFactory->createService($serviceLocatorMock);
        $this->assertInstanceOf('\Cloudbooks\Author\Service\AuthorService', $authorService);
    }
}