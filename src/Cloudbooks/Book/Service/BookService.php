<?php

namespace Cloudbooks\Book\Service;

use Cloudbooks\Book\Interfaces\BookInterface;
use Cloudbooks\Common\Interfaces\TableGatewayInterface;
use Cloudbooks\Common\Interfaces\HydratorInterface;

class BookService
{
    /**
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var BookInterface
     */
    protected $bookEntity;

    public function __construct(
        TableGatewayInterface $tableGateway,
        HydratorInterface $hydrator,
        BookInterface $bookEntity
    )
    {
        $this->tableGateway = $tableGateway;
        $this->hydrator = $hydrator;
        $this->bookEntity = $bookEntity;
    }

    public function listBooks(int $memberId): array
    {
        $bookList = $this->tableGateway->fetchAll(array ('member_id = ?' => $memberId));
        return $bookList;
    }

    public function getBook(int $memberId, int $bookId): BookInterface
    {
        $bookData = $this->tableGateway->fetchRow(array (
            'member_id = ?' => $memberId,
            'book_id = ?' => $bookId,
        ));
        return $this->hydrator->hydrate($bookData, $this->bookEntity);
    }

    public function addBook(BookInterface $bookEntity)
    {
        $data = $this->hydrator->extract($bookEntity);
        unset ($data['id']);
        $result = $this->tableGateway->insert($data);
        $bookEntity->setId($result);
        return $bookEntity;
    }

    public function updateBook(BookInterface $bookEntity)
    {
        $id = $bookEntity->getId();
        if (0 === $id) {
            throw new \InvalidArgumentException('To update a book, a valid ID is required: ' . $id);
        }
        $data = $this->hydrator->extract($bookEntity);
        unset ($data['id']);
        $result = $this->tableGateway->update($data, ['id = ?' => $id]);
        return $bookEntity;
    }
}