<?php

namespace Cloudbooks\Author\Interfaces;

interface AuthorInterface
{
    public function getId(): int;
    public function getName(): string;
    public function getBiography(): string;
}
