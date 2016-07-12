<?php

namespace Cloudbooks\Member\Service;

use Cloudbooks\Member\Interfaces\MemberInterface;
use Cloudbooks\Common\Interfaces\HydratorInterface;
use Cloudbooks\Common\Interfaces\TableGatewayInterface;

class MemberService
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
     * @var MemberInterface
     */
    protected $memberEntity;

    /**
     * AuthorService constructor.
     *
     * @param TableGatewayInterface $tableGateway
     * @param HydratorInterface $hydrator
     * @param MemberInterface $memberEntity
     */
    public function __construct(
        TableGatewayInterface $tableGateway,
        HydratorInterface $hydrator,
        MemberInterface $memberEntity
    ) {
    
        $this->tableGateway = $tableGateway;
        $this->hydrator = $hydrator;
        $this->memberEntity = $memberEntity;
    }

    public function listMembers(): array
    {
        return $this->tableGateway->fetchAll();
    }

    public function getMember($memberId): MemberInterface
    {
        $data = $this->tableGateway->fetchRow(['id = ?' => $memberId]);
        return $this->hydrator->hydrate($data, $this->memberEntity);
    }

    public function addMember(MemberInterface $memberEntity): MemberInterface
    {
        $data = $this->hydrator->extract($memberEntity);
        unset($data['id']);
        $lastId = $this->tableGateway->insert($data);
        $memberEntity->setId($lastId);
        return $memberEntity;
    }

    public function updateMember(MemberInterface $memberEntity): int
    {
        $id = $memberEntity->getId();
        if (0 === $id) {
            throw new \InvalidArgumentException('Invalid ID provided for this member entity: ' . $id);
        }
        $data = $this->hydrator->extract($memberEntity);
        unset($data['id']);
        $updatedRows = $this->tableGateway->update($data, ['id = ?' => $id]);
        return $updatedRows;
    }

    public function authenticate(string $username, string $password): bool
    {
        $resultSet = $this->tableGateway->fetchRow([
            'username = ?' => $username,
            'password = ?' => $password,
        ]);
        if ([] === $resultSet) {
            return false;
        }
        return true;
    }
}
