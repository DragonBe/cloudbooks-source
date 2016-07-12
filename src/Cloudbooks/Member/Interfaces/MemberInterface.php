<?php

namespace Cloudbooks\Member\Interfaces;

interface MemberInterface
{
    public function getId(): int;
    public function getEmail(): string;
    public function getPassword(): string;
    public function getName(): string;
}
