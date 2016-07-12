<?php

namespace Cloudbooks\Book\Entity;

use Cloudbooks\Book\Interfaces\BookInterface;

class Book implements BookInterface
{
    /**
     * @var int
     */
    protected $id = 0;
    /**
     * @var string
     */
    protected $title = '';
    /**
     * @var string
     */
    protected $abstract = '';
    /**
     * @var string
     */
    protected $isbn = '';
    /**
     * @var int
     */
    protected $authorId = 0;
    /**
     * @var int
     */
    protected $memberId = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Book
     */
    public function setId(int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle(string $title): Book
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getAbstract(): string
    {
        return $this->abstract;
    }

    /**
     * @param string $abstract
     * @return Book
     */
    public function setAbstract(string $abstract): Book
    {
        $this->abstract = $abstract;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     * @return Book
     */
    public function setIsbn(string $isbn): Book
    {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     * @return Book
     */
    public function setAuthorId(int $authorId): Book
    {
        $this->authorId = $authorId;
        return $this;
    }

    /**
     * @return int
     */
    public function getMemberId(): int
    {
        return $this->memberId;
    }

    /**
     * @param int $memberId
     * @return Book
     */
    public function setMemberId(int $memberId): Book
    {
        $this->memberId = $memberId;
        return $this;
    }

}