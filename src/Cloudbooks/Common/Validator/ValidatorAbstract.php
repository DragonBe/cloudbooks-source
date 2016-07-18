<?php

namespace Cloudbooks\Common\Validator;

use Cloudbooks\Common\Interfaces\ValidatorInterface;

abstract class ValidatorAbstract implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * ValidatorAbstract constructor.
     */
    public function __construct()
    {
        $this->errors = [];
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
