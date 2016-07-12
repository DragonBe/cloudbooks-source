<?php

namespace Cloudbooks\Test\Member\Factory;

use Cloudbooks\Common\Interfaces\ServiceFactoryInterface;
use Cloudbooks\Member\Factory\MemberServiceFactory;

class MemberServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceFactoryImplementsServiceFactoryInterface()
    {
        $memberServiceFactory = new MemberServiceFactory();
        $this->assertInstanceOf('\Cloudbooks\Common\Interfaces\ServiceFactoryInterface', $memberServiceFactory);
        return $memberServiceFactory;
    }

    /**
     * @depends testServiceFactoryImplementsServiceFactoryInterface
     */
    public function testServiceFactoryCreatesService(ServiceFactoryInterface $memberServiceFactory)
    {
        // Prepare object mocks
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();
        $serviceLocatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ServiceLocatorInterface')->getMock();

        // Create a return value map
        $valueMap = [
            ['\Cloudbooks\Member\Model\MemberTable', $tableGatewayMock],
            ['\Cloudbooks\Member\Model\MemberHydrator', $hydratorMock],
            ['\Cloudbooks\Member\Entity\Member', $memberEntityMock],
        ];

        // Create the stub
        $serviceLocatorMock->expects($this->exactly(3))
            ->method('get')
            ->will($this->returnValueMap($valueMap));

        // Run the tests
        $memberService = $memberServiceFactory->createService($serviceLocatorMock);
        $this->assertInstanceOf('\Cloudbooks\Member\Service\MemberService', $memberService);

    }
}