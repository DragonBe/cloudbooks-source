<?php

namespace Cloudbooks\Test\Member\Entity;

use Cloudbooks\Member\Entity\Member;
use Cloudbooks\Member\Interfaces\MemberInterface;

class MemberTest extends \PHPUnit_Framework_TestCase
{
    public function testEntityImplementsInteface()
    {
        $member = new Member();
        $this->assertInstanceOf('\Cloudbooks\Member\Interfaces\MemberInterface', $member);
        return $member;
    }

    /**
     * @depends testEntityImplementsInteface
     * @covers \Cloudbooks\Member\Entity\Member::getId
     * @covers \Cloudbooks\Member\Entity\Member::getEmail
     * @covers \Cloudbooks\Member\Entity\Member::getName
     * @covers \Cloudbooks\Member\Entity\Member::getPassword
     */
    public function testEntityIsEmptyAtConstruct(MemberInterface $member)
    {
        $this->assertSame(0, $member->getId());
        $this->assertSame('', $member->getEmail());
        $this->assertSame('', $member->getName());
        $this->assertSame('', $member->getPassword());
    }

    /**
     * @depends testEntityImplementsInteface
     * @covers \Cloudbooks\Member\Entity\Member::setId
     * @covers \Cloudbooks\Member\Entity\Member::setEmail
     * @covers \Cloudbooks\Member\Entity\Member::setName
     * @covers \Cloudbooks\Member\Entity\Member::setPassword
     * @covers \Cloudbooks\Member\Entity\Member::getId
     * @covers \Cloudbooks\Member\Entity\Member::getEmail
     * @covers \Cloudbooks\Member\Entity\Member::getName
     * @covers \Cloudbooks\Member\Entity\Member::getPassword
     */
    public function testEntityCanBePopulated(MemberInterface $member)
    {
        $data = [
            'id' => 1,
            'email' => 'foo@bar.baz',
            'name' => 'Foo Bar',
            'password' => 'FooBarB@Z!',
        ];

        $member->setId($data['id'])
            ->setEmail($data['email'])
            ->setName($data['name'])
            ->setPassword($data['password']);

        $this->assertSame($data['id'], $member->getId());
        $this->assertSame($data['email'], $member->getEmail());
        $this->assertSame($data['name'], $member->getName());
        $this->assertSame($data['password'], $member->getPassword());
    }
}