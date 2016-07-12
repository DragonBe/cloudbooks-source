<?php

namespace Cloudbooks\Test\Book\Model;

use Cloudbooks\Book\Entity\Book;
use Cloudbooks\Book\Model\BookHydrator;

class BookHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Cloudbooks\Book\Model\BookHydrator::hydrate
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::hydrate
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::snakeToCamel
     */
    public function testHydratorCanHydrateDataFromArrayIntoEntity()
    {
        $data = [
            'id' => 1,
            'title' => 'Foo',
            'abstract' => 'Foo bar',
            'isbn' => '01234567890123',
            'author_id' => 1,
            'member_id' => 1,
        ];
        $bookEntity = new Book();
        $bookHydrator = new BookHydrator();
        $bookHydrator->hydrate($data, $bookEntity);

        $this->assertSame($data['id'], $bookEntity->getId());
        $this->assertSame($data['title'], $bookEntity->getTitle());
        $this->assertSame($data['abstract'], $bookEntity->getAbstract());
        $this->assertSame($data['isbn'], $bookEntity->getIsbn());
        $this->assertSame($data['author_id'], $bookEntity->getAuthorId());
        $this->assertSame($data['member_id'], $bookEntity->getMemberId());
    }

    /**
     * @covers \Cloudbooks\Book\Model\BookHydrator::extract
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::extract
     * @covers \Cloudbooks\Common\Hydrator\BasicHydratorAbstract::camelToSnake
     */
    public function testHydratorCanExtractDataEntityIntoArray()
    {
        $data = [
            'id' => 1,
            'title' => 'Foo',
            'abstract' => 'Foo bar',
            'isbn' => '01234567890123',
            'author_id' => 1,
            'member_id' => 1,
        ];
        $bookEntity = new Book();

        $bookEntity->setId($data['id'])
            ->setTitle($data['title'])
            ->setAbstract($data['abstract'])
            ->setIsbn($data['isbn'])
            ->setAuthorId($data['author_id'])
            ->setMemberId($data['member_id']);

        $bookHydrator = new BookHydrator();
        $result = $bookHydrator->extract($bookEntity);
        $this->assertSame($data, $result);
    }
}