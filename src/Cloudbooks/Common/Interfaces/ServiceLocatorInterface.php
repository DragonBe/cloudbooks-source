<?php

namespace Cloudbooks\Common\Interfaces;

interface ServiceLocatorInterface
{
    public function get(string $object);
}
