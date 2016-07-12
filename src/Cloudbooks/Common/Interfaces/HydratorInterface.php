<?php

namespace Cloudbooks\Common\Interfaces;

interface HydratorInterface
{
    /**
     * Extracts data from an entity object and converts
     * it into an array.
     *
     * @param mixed $object
     * @return array
     */
    public function extract($object): array;

    /**
     * Hydrates values from an array into an entity object
     *
     * @param array $data
     * @param mixed $object
     * @return mixed
     */
    public function hydrate(array $data, $object);
}
