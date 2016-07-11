<?php

namespace Cloudbooks\Author\Service;

use Cloudbooks\Author\Interfaces\AuthorInterface;
use Cloudbooks\Common\Interfaces\HydratorInterface;
use Cloudbooks\Common\Interfaces\TableGatewayInterface;

class AuthorService
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
     * @var AuthorInterface
     */
    protected $authorEntity;

    /**
     * AuthorService constructor.
     *
     * @param TableGatewayInterface $tableGateway
     * @param HydratorInterface $hydrator
     * @param AuthorInterface $authorEntity
     */
    public function __construct(
        TableGatewayInterface $tableGateway,
        HydratorInterface $hydrator,
        AuthorInterface $authorEntity
    )
    {
        $this->tableGateway = $tableGateway;
        $this->hydrator = $hydrator;
        $this->authorEntity = $authorEntity;
    }

    public function listAuthors(int $memberId): array
    {
        $resultSet = $this->tableGateway->fetchAll(['member_id = ?' => $memberId]);
        return $resultSet;
    }

    public function getAuthor(int $memberId, int $authorId): AuthorInterface
    {
        $resultRow = $this->tableGateway->fetchRow([
            'member_id = ?' => $memberId,
            'id = ?' => $authorId,
        ]);
        return $this->hydrator->hydrate($resultRow, $this->authorEntity);
    }
    
    public function addAuthor(AuthorInterface $authorEntity): AuthorInterface
    {
        $data = $this->hydrator->extract($authorEntity);
        unset ($data['id']);
        $id = $this->tableGateway->insert($data);
        $authorEntity->setId($id);
        return $authorEntity;
    }

    public function updateAuthor(AuthorInterface $authorEntity): int
    {
        $id = $authorEntity->getId();
        if (0 === $id) {
            throw new \InvalidArgumentException('Wrong ID provided for updating this entity');
        }
        $data = $this->hydrator->extract($authorEntity);
        unset ($data['id']);
        $updatedRows = $this->tableGateway->update($data, ['id = ?' => $id]);
        return $updatedRows;
    }

}