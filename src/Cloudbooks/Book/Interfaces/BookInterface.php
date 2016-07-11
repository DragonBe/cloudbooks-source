<?php

namespace Cloudbooks\Book\Interfaces;

interface BookInterface
{
    public function getId(): int;
    public function getTitle(): string;
    public function getAbstract(): string;
    public function getIsbn(): string;
    public function getAuthorId(): int;
    public function getMemberId(): int;
}