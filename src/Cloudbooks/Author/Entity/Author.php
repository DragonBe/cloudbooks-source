<?php

namespace Cloudbooks\Author\Entity;

use Cloudbooks\Author\Interfaces\AuthorInterface;

class Author implements AuthorInterface
{
    /**
     * @var int
     */
    protected $id = 0;
    /**
     * @var string
     */
    protected $name = '';
    /**
     * @var string
     */
    protected $biography = '';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Author
     */
    public function setId(int $id): Author
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Author
     */
    public function setName(string $name): Author
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     * @return Author
     */
    public function setBiography(string $biography): Author
    {
        $this->biography = $biography;
        return $this;
    }
}
