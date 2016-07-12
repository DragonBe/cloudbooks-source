<?php

namespace Cloudbooks\Common\Interfaces;

interface ServiceLocatorInterface
{
    /**
     * Retrieve a service object from the registry
     *
     * @param string $objectReference
     * @return mixed
     */
    public function get(string $objectReference);
}
