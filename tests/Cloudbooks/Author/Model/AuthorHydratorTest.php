<?php

namespace Cloudbooks\Test\Author\Model;

use Cloudbooks\Author\Entity\Author;
use Cloudbooks\Author\Model\AuthorHydrator;

class AuthorHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Cloudbooks\Author\Model\AuthorHydrator::hydrate
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::hydrate
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::snakeToCamel
     */
    public function testHydratorCanHydrateDataFromArrayIntoEntity()
    {
        $array = [
            'id' => 1,
            'name' => 'Foo Bar',
            'biography' => 'Foo Bar baz foo-bar',
        ];
        $authorEntity = new Author();
        $authorHydrator = new AuthorHydrator();
        $authorHydrator->hydrate($array, $authorEntity);

        $this->assertInstanceOf('\Cloudbooks\Author\Interfaces\AuthorInterface', $authorEntity);
        $this->assertInstanceOf('\Cloudbooks\Author\Entity\Author', $authorEntity);
        $this->assertSame($array['id'], $authorEntity->getId());
        $this->assertSame($array['name'], $authorEntity->getName());
        $this->assertSame($array['biography'], $authorEntity->getBiography());
    }

    /**
     * @covers \Cloudbooks\Author\Model\AuthorHydrator::extract
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::extract
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::camelToSnake
     */
    public function testHydratorCanExtractDataEntityIntoArray()
    {
        $array = [
            'id' => 1,
            'name' => 'Foo Bar',
            'biography' => 'Foo Bar baz foo-bar',
        ];
        $authorEntity = new Author();
        $authorEntity->setId($array['id'])
            ->setName($array['name'])
            ->setBiography($array['biography']);

        $authorHydrator = new AuthorHydrator();
        $result = $authorHydrator->extract($authorEntity);

        $this->assertInternalType('array', $result);
        $this->assertSame($array, $result);
    }
}