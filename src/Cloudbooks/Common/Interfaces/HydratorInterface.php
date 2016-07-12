<?php

namespace Cloudbooks\Common\Interfaces;

interface HydratorInterface
{
    public function extract($object): array;
    public function hydrate(array $data, $object);
}
