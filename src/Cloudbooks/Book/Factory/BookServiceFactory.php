<?php

namespace Cloudbooks\Book\Factory;

use Cloudbooks\Book\Service\BookService;
use Cloudbooks\Common\Interfaces\ServiceFactoryInterface;
use Cloudbooks\Common\Interfaces\ServiceLocatorInterface;

class BookServiceFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $bookTableGateway = $serviceLocator->get('\Cloudbooks\Book\Model\BookTable');
        $bookHydrator = $serviceLocator->get('\Cloudbooks\Book\Model\BookHydrator');
        $bookEntity = $serviceLocator->get('\Cloudbooks\Book\Entity\Book');

        return new BookService($bookTableGateway, $bookHydrator, $bookEntity);
    }
}
