<?php

namespace Cloudbooks\Common\Interfaces;

interface ValidatorInterface
{
    /**
     * Validates a set of data and returns boolean TRUE
     * if the provided data matches the validation rules
     * or boolean FALSE when the validation failed.
     *
     * @param array $data
     * @return bool
     */
    public function isValid(array $data): bool;

    /**
     * If validation failes for one or more elements, an
     * array of errors will be returned explaining the reason
     * why the validation failed.
     *
     * @return array
     */
    public function getErrors(): array;
}
