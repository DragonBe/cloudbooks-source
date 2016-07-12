<?php

namespace Cloudbooks\Common\Interfaces;

interface TableGatewayInterface
{
    /**
     * @param int $id
     * @return array
     */
    public function find(int $id): array;

    /**
     * @param array $where
     * @param array $order
     * @return array
     */
    public function fetchRow(array $where = [], array $order = []): array;

    /**
     * @param array $where
     * @param array $order
     * @param int $count
     * @param int $offset
     * @return array
     */
    public function fetchAll(array $where = [], array $order = [], int $count = 0, int $offset = 0): array;

    /**
     * @param array $data
     * @return int
     */
    public function insert(array $data): int;

    /**
     * @param array $data
     * @param array $where
     * @return int
     */
    public function update(array $data, array $where = []): int;
}
