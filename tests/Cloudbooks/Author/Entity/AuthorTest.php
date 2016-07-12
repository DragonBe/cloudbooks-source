<?php

namespace Cloudbooks\Test\Author\Entity;

use Cloudbooks\Author\Entity\Author;
use Cloudbooks\Author\Interfaces\AuthorInterface;

class AuthorTest extends \PHPUnit_Framework_TestCase
{
    public function testEntityImplementsInterface()
    {
        $author = new Author();
        $this->assertInstanceOf('\Cloudbooks\Author\Interfaces\AuthorInterface', $author);
        return $author;
    }

    /**
     * @depends testEntityImplementsInterface
     * @covers \Cloudbooks\Author\Entity\Author::getId
     * @covers \Cloudbooks\Author\Entity\Author::getName
     * @covers \Cloudbooks\Author\Entity\Author::getBiography
     */
    public function testEntityIsEmptyAtConstruct(AuthorInterface $author)
    {
        $this->assertSame(0, $author->getId());
        $this->assertSame('', $author->getName());
        $this->assertSame('', $author->getBiography());
    }

    /**
     * @depends testEntityImplementsInterface
     * @covers \Cloudbooks\Author\Entity\Author::setId
     * @covers \Cloudbooks\Author\Entity\Author::setName
     * @covers \Cloudbooks\Author\Entity\Author::setBiography
     * @covers \Cloudbooks\Author\Entity\Author::getId
     * @covers \Cloudbooks\Author\Entity\Author::getName
     * @covers \Cloudbooks\Author\Entity\Author::getBiography
     */
    public function testEntityCanBePopulated(AuthorInterface $author)
    {
        $data = [
            'id' => 1,
            'name' => 'Foo bar',
            'biography' => 'Foo bar was originated as a test example',
        ];

        $author->setId($data['id'])
            ->setName($data['name'])
            ->setBiography($data['biography']);

        $this->assertSame($data['id'], $author->getId());
        $this->assertSame($data['name'], $author->getName());
        $this->assertSame($data['biography'], $author->getBiography());
    }
}