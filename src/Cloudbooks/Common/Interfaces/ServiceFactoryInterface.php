<?php

namespace Cloudbooks\Common\Interfaces;

/**
 * Interface ServiceFactoryInterface
 *
 * This interface allows you to inject a dependency injection
 * container into the factory so required dependencies can be
 * instantiated for an object is instantiated following the
 * Inversion of Control concept.
 *
 * @package Cloudbooks\Common\Interfaces
 * @link http://martinfowler.com/articles/injection.html
 */
interface ServiceFactoryInterface
{
    /**
     * Creates the service using the Service Locator pattern
     * pulling dependencies from the service locator and injects
     * them into the constructor from the concrete service class.
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator);
}