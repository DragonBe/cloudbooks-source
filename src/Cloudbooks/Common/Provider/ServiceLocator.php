<?php

namespace Cloudbooks\Common\Provider;

use Cloudbooks\Common\Interfaces\ServiceLocatorInterface;

class ServiceLocator implements ServiceLocatorInterface
{
    protected $registry = [];

    /**
     * @inheritDoc
     */
    public function get(string $objectReference)
    {
        if (array_key_exists($objectReference, $this->registry)) {
            return $this->registry[$objectReference];
        }
        return null;
    }

    public function set(string $objectReference, $object): ServiceLocator
    {
        if (array_key_exists($objectReference, $this->registry)) {
            throw new \InvalidArgumentException($objectReference . ' already was registered');
        }
        $this->registry[$objectReference] = $object;
        return $this;
    }
}
