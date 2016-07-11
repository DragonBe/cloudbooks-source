<?php

namespace Cloudbooks\Test\Member\Service;

use Cloudbooks\Member\Interfaces\MemberInterface;
use Cloudbooks\Member\Service\MemberService;

class MemberServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Cloudbooks\Member\Service\MemberService::__construct
     * @expectedException \TypeError
     */
    public function testMemberServiceRequiresArgumentsAtConstruct()
    {
        $memberService = new MemberService();
        $this->fail('Expected error was not triggered for missing constructor arguments');
    }

    /**
     * @covers Cloudbooks\Member\Service\MemberService::__construct
     * @expectedException \TypeError
     */
    public function testMemberServiceRequiresCorrectArgumentsAtConstruct()
    {
        $tableGatewayMock = $this->getMockBuilder('\stdClass')->getMock();
        $hydratorMock = $this->getMockBuilder('\stdClass')->getMock();
        $memberEntityMock = $this->getMockBuilder('\stdClass')->getMock();

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock);
        $this->fail('Expected error was not triggered for wrong constructor arguments');
    }

    /**
     * @covers Cloudbooks\Member\Service\MemberService::__construct
     * @covers Cloudbooks\Member\Service\MemberService::listMembers
     */
    public function testMemberServiceListMembers()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();

        $tableGatewayMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn([$memberEntityMock]);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock);
        $memberList = $memberService->listMembers();
        $this->assertCount(1, $memberList);
        $memberEntity = array_shift($memberList);
        $this->assertInstanceOf('\Cloudbooks\Member\Interfaces\MemberInterface', $memberEntity);
    }

    /**
     * @covers Cloudbooks\Member\Service\MemberService::__construct
     * @covers Cloudbooks\Member\Service\MemberService::getMember
     */
    public function testMemberServiceDisplaysSingleMember()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();

        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->willReturn($memberEntityMock);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock);
        $memberEntity = $memberService->getMember(1);
        $this->assertInstanceOf('\Cloudbooks\Member\Interfaces\MemberInterface', $memberEntity);
    }

    /**
     * @covers Cloudbooks\Member\Service\MemberService::__construct
     * @covers Cloudbooks\Member\Service\MemberService::addMember
     */
    public function testMemberServiceAddMember()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')
            ->setMethods(['getId', 'getEmail', 'getPassword', 'getName', 'setId'])
            ->getMock();

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock);
        $memberEntity = $memberService->addMember($memberEntityMock);
        $this->assertInstanceOf('\Cloudbooks\Member\Interfaces\MemberInterface', $memberEntity);
    }

    /**
     * @covers Cloudbooks\Member\Service\MemberService::__construct
     * @covers Cloudbooks\Member\Service\MemberService::updateMember
     * @expectedException \InvalidArgumentException
     */
    public function testMemberServiceUpdatesMemberWithWrongIdThrowsException()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock);
        $memberEntity = $memberService->updateMember($memberEntityMock);
        $this->fail('Expected exception was not triggered for wrong ID');
    }

    /**
     * @covers Cloudbooks\Member\Service\MemberService::__construct
     * @covers Cloudbooks\Member\Service\MemberService::updateMember
     */
    public function testMemberServiceUpdatesMember()
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();

        $memberEntityMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $tableGatewayMock->expects($this->once())
            ->method('update')
            ->willReturn(1);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock);
        $updatedRecords = $memberService->updateMember($memberEntityMock);
        $this->assertSame(1, $updatedRecords);
    }

}