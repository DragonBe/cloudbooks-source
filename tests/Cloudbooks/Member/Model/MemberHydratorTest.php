<?php

namespace Cloudbooks\Test\Member\Model;

use Cloudbooks\Member\Entity\Member;
use Cloudbooks\Member\Model\MemberHydrator;

class MemberHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Cloudbooks\Member\Model\MemberHydrator::hydrate
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::hydrate
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::snakeToCamel
     */
    public function testHydratorCanHydrateDataFromArrayIntoEntity()
    {
        $data = [
            'id' => 1,
            'email' => 'foo@bar.baz',
            'name' => 'Foo Bar',
            'password' => 'FooBarB@Z!',
        ];

        $memberEntity = new Member();
        $memberHydrator = new MemberHydrator();

        $memberHydrator->hydrate($data, $memberEntity);

        $this->assertSame($data['id'], $memberEntity->getId());
        $this->assertSame($data['email'], $memberEntity->getEmail());
        $this->assertSame($data['name'], $memberEntity->getName());
        $this->assertSame($data['password'], $memberEntity->getPassword());
    }

    /**
     * @covers \Cloudbooks\Member\Model\MemberHydrator::extract
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::extract
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::camelToSnake
     */
    public function testHydratorCanExtractDataEntityIntoArray()
    {
        $data = [
            'id' => 1,
            'email' => 'foo@bar.baz',
            'name' => 'Foo Bar',
            'password' => 'FooBarB@Z!',
        ];
        $memberEntity = new Member();
        $memberEntity->setId($data['id'])
            ->setEmail($data['email'])
            ->setName($data['name'])
            ->setPassword($data['password']);

        $memberHydrator = new MemberHydrator();
        $result = $memberHydrator->extract($memberEntity);
        $this->assertSame($data, $result);
    }
}