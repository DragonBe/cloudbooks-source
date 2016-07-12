<?php

namespace Cloudbooks\Author\Factory;

use Cloudbooks\Author\Service\AuthorService;
use Cloudbooks\Common\Interfaces\ServiceFactoryInterface;
use Cloudbooks\Common\Interfaces\ServiceLocatorInterface;

class AuthorServiceFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authorTable = $serviceLocator->get('\Cloudbooks\Author\Model\AuthorTable');
        $authorHydrator = $serviceLocator->get('\Cloudbooks\Author\Model\AuthorHydrator');
        $authorEntity = $serviceLocator->get('\Cloudbooks\Author\Entity\Author');

        return new AuthorService($authorTable, $authorHydrator, $authorEntity);
    }
}
