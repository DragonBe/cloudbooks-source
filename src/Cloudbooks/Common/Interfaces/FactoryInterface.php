<?php

namespace Cloudbooks\Common\Interfaces;

/**
 * Interface FactoryInterface
 *
 * This interface allows you to inject a dependency injection
 * container into the factory so required dependencies can be
 * instantiated for an object is instantiated following the
 * Inversion of Control concept.
 *
 * @package Cloudbooks\Common\Interfaces
 * @link http://martinfowler.com/articles/injection.html
 */
interface FactoryInterface
{

    public function create($diContainer);
}