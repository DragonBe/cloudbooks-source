<?php

namespace Cloudbooks\Test\Book\Entity;

use Cloudbooks\Book\Entity\Book;
use Cloudbooks\Book\Interfaces\BookInterface;

class BookTest extends \PHPUnit_Framework_TestCase
{
    public function testBookEntityImplementsBookInterface()
    {
        $book = new Book();
        $this->assertInstanceOf('\Cloudbooks\Book\Interfaces\BookInterface', $book);
        return $book;
    }

    /**
     * @depends testBookEntityImplementsBookInterface
     * @covers \Cloudbooks\Book\Entity\Book::getId
     * @covers \Cloudbooks\Book\Entity\Book::getTitle
     * @covers \Cloudbooks\Book\Entity\Book::getAbstract
     * @covers \Cloudbooks\Book\Entity\Book::getIsbn
     * @covers \Cloudbooks\Book\Entity\Book::getAuthorId
     * @covers \Cloudbooks\Book\Entity\Book::getMemberId
     */
    public function testBookEntityIsEmptyAtConstruct(BookInterface $book)
    {
        $this->assertSame(0, $book->getId());
        $this->assertSame('', $book->getTitle());
        $this->assertSame('', $book->getAbstract());
        $this->assertSame('', $book->getIsbn());
        $this->assertSame(0, $book->getAuthorId());
        $this->assertSame(0, $book->getMemberId());
    }

    /**
     * @depends testBookEntityImplementsBookInterface
     * @covers \Cloudbooks\Book\Entity\Book::setId
     * @covers \Cloudbooks\Book\Entity\Book::setTitle
     * @covers \Cloudbooks\Book\Entity\Book::setAbstract
     * @covers \Cloudbooks\Book\Entity\Book::setIsbn
     * @covers \Cloudbooks\Book\Entity\Book::setAuthorId
     * @covers \Cloudbooks\Book\Entity\Book::setMemberId
     * @covers \Cloudbooks\Book\Entity\Book::getId
     * @covers \Cloudbooks\Book\Entity\Book::getTitle
     * @covers \Cloudbooks\Book\Entity\Book::getAbstract
     * @covers \Cloudbooks\Book\Entity\Book::getIsbn
     * @covers \Cloudbooks\Book\Entity\Book::getAuthorId
     * @covers \Cloudbooks\Book\Entity\Book::getMemberId
     */
    public function testBookEntityCanBePopulated(BookInterface $book)
    {
        $data = [
            'id' => 1,
            'title' => 'Foo',
            'abstract' => 'Foo bar baz foo-bar',
            'isbn' => '01234567890123',
            'author_id' => 1,
            'member_id' => 1,
        ];

        $book->setId($data['id'])
            ->setTitle($data['title'])
            ->setAbstract($data['abstract'])
            ->setIsbn($data['isbn'])
            ->setAuthorId($data['author_id'])
            ->setMemberId($data['member_id']);

        $this->assertSame($data['id'], $book->getId());
        $this->assertSame($data['title'], $book->getTitle());
        $this->assertSame($data['abstract'], $book->getAbstract());
        $this->assertSame($data['isbn'], $book->getIsbn());
        $this->assertSame($data['author_id'], $book->getAuthorId());
        $this->assertSame($data['member_id'], $book->getMemberId());
    }
}