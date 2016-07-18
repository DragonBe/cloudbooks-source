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
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
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
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $tableGatewayMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn([$memberEntityMock]);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
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
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $hydratorMock->expects($this->once())
            ->method('hydrate')
            ->willReturn($memberEntityMock);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
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
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
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
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
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
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $memberEntityMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $tableGatewayMock->expects($this->once())
            ->method('update')
            ->willReturn(1);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
        $updatedRecords = $memberService->updateMember($memberEntityMock);
        $this->assertSame(1, $updatedRecords);
    }

    public function loginProvider()
    {
        return [
            ['foo', 'bar'],
            ['foo@bar.baz', 'FooBarB@Z!'],
            ['foobar@baz', 'FooBarB@Z!FooBar-'],
        ];
    }
    /**
     * @dataProvider loginProvider
     * @covers \Cloudbooks\Member\Service\MemberService::__construct
     * @covers \Cloudbooks\Member\Service\MemberService::authenticate
     */
    public function testMemberCanNotAuthenticateWithWrongCredentials($username, $password)
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $tableGatewayMock->expects($this->once())
            ->method('fetchRow')
            ->willReturn([]);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
        $auth = $memberService->authenticate($username, $password);
        $this->assertFalse($auth);
    }
    /**
     * @dataProvider loginProvider
     * @covers \Cloudbooks\Member\Service\MemberService::__construct
     * @covers \Cloudbooks\Member\Service\MemberService::authenticate
     */
    public function testMemberCanAuthenticateWithCorrectCredentials($username, $password)
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $tableGatewayMock->expects($this->once())
            ->method('fetchRow')
            ->willReturn([
                'id' => rand(1, 10000),
                'email' => $username,
                'name' => 'Foo Bar',
                'password' => $password,
            ]);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
        $auth = $memberService->authenticate($username, $password);
        $this->assertTrue($auth);
    }

    /**
     * DataProvider that provides bad data for the registration process
     *
     * @return array
     */
    public function badRegistrationDataProvider()
    {
        return [
            ['', '', ''],
            ['foo', 'foo', 'foo'],
        ];
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @dataProvider badRegistrationDataProvider
     * @covers \Cloudbooks\Member\Service\MemberService::__construct
     * @covers \Cloudbooks\Member\Service\MemberService::registerNewMember
     * @expectedException \InvalidArgumentException
     */
    public function testMemberCannotRegisterWithWrongInformation(string $name, string $email, string $password)
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $memberValidatorMock->expects($this->once())
            ->method('isValid')
            ->willReturn(false);
        $memberValidatorMock->expects($this->once())
            ->method('getErrors')
            ->willReturn([
                'name' => 'Invalid name provided',
                'username' => 'Invalid username provided',
                'password' => 'Invalid password provided',
            ]);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
        $memberService->registerNewMember($name, $email, $password);
        $this->fail('Expected exception for invalid member details was not triggered');
    }

    public function goodRegistrationDataProvider()
    {
        return [
            ['John Doe', 'john.doe@company.com', 'ljdsaljdoquerq!123#'],
            ['Jane Doe', 'jane.doe@organization.org', 'foo bar baz foo-bar!'],
        ];
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @dataProvider goodRegistrationDataProvider
     * @covers \Cloudbooks\Member\Service\MemberService::__construct
     * @covers \Cloudbooks\Member\Service\MemberService::registerNewMember
     */
    public function testMemberCanRegisterWithCorrectInformation(string $name, string $email, string $password)
    {
        $tableGatewayMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\TableGatewayInterface')->getMock();
        $hydratorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\HydratorInterface')->getMock();
        $memberEntityMock = $this->getMockBuilder('\Cloudbooks\Member\Interfaces\MemberInterface')->getMock();
        $memberValidatorMock = $this->getMockBuilder('\Cloudbooks\Common\Interfaces\ValidatorInterface')->getMock();

        $tableGatewayMock->expects($this->once())
            ->method('insert')
            ->willReturn(1);

        $memberValidatorMock->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $memberService = new MemberService($tableGatewayMock, $hydratorMock, $memberEntityMock, $memberValidatorMock);
        $result = $memberService->registerNewMember($name, $email, $password);
        $this->assertSame(1, $result);
    }
}