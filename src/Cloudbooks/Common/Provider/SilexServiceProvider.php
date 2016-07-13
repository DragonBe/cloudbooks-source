<?php

namespace Cloudbooks\Common\Provider;

use Cloudbooks\Author\Entity\Author;
use Cloudbooks\Author\Factory\AuthorServiceFactory;
use Cloudbooks\Author\Model\AuthorHydrator;
use Cloudbooks\Author\Model\AuthorTable;
use Cloudbooks\Book\Entity\Book;
use Cloudbooks\Book\Factory\BookServiceFactory;
use Cloudbooks\Book\Model\BookHydrator;
use Cloudbooks\Book\Model\BookTable;
use Cloudbooks\Member\Entity\Member;
use Cloudbooks\Member\Factory\MemberServiceFactory;
use Cloudbooks\Member\Model\MemberHydrator;
use Cloudbooks\Member\Model\MemberTable;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class SilexServiceProvider
 *
 * @package Cloudbooks\Common\Provider
 * @codeCoverageIgnore
 */
class SilexServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $container)
    {
        $dsn = $container['cb_config_db.dsn'] ?: '';
        $username = $container['cb_config_db.username'] ?: '';
        $password = $container['cb_config_db.password'] ?: '';
        $pdo = new \PDO($dsn, $username, $password);

        $authorTable = new AuthorTable($pdo);
        $authorHydrator = new AuthorHydrator();
        $author = new Author();

        $bookTable = new BookTable($pdo);
        $bookHydrator = new BookHydrator();
        $book = new Book();
        
        $memberTable = new MemberTable($pdo);
        $memberHydrator = new MemberHydrator();
        $member = new Member();

        $serviceLocator = new ServiceLocator();
        $serviceLocator
            ->set('\Cloudbooks\Author\Model\AuthorTable', $authorTable)
            ->set('\Cloudbooks\Author\Model\AuthorHydrator', $authorHydrator)
            ->set('\Cloudbooks\Author\Entity\Author', $author)
            ->set('\Cloudbooks\Book\Model\BookTable', $bookTable)
            ->set('\Cloudbooks\Book\Model\BookHydrator', $bookHydrator)
            ->set('\Cloudbooks\Book\Entity\Book', $book)
            ->set('\Cloudbooks\Member\Model\MemberTable', $memberTable)
            ->set('\Cloudbooks\Member\Model\MemberHydrator', $memberHydrator)
            ->set('\Cloudbooks\Member\Entity\Member', $member);

        $container['cb_author_service'] = $container->factory(function () use ($serviceLocator) {
            $serviceFactory = new AuthorServiceFactory();
            return $serviceFactory->createService($serviceLocator);
        });
        $container['cb_book_service'] = $container->factory(function () use ($serviceLocator) {
            $serviceFactory = new BookServiceFactory();
            return $serviceFactory->createService($serviceLocator);
        });
        $container['cb_member_service'] = $container->factory(function () use ($serviceLocator) {
            $serviceFactory = new MemberServiceFactory();
            return $serviceFactory->createService($serviceLocator);
        });
    }
}
