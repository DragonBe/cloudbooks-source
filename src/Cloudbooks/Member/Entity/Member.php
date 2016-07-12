<?php

namespace Cloudbooks\Member\Entity;

use Cloudbooks\Member\Interfaces\MemberInterface;

class Member implements MemberInterface
{
    /**
     * @var int
     */
    protected $id = 0;
    /**
     * @var string
     */
    protected $email = '';
    /**
     * @var string
     */
    protected $name = '';
    /**
     * @var string
     */
    protected $password = '';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Member
     */
    public function setId(int $id): Member
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Member
     */
    public function setEmail(string $email): Member
    {
        $this->email = $email;
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
     * @return Member
     */
    public function setName(string $name): Member
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Member
     */
    public function setPassword(string $password): Member
    {
        $this->password = $password;
        return $this;
    }
}
