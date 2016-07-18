<?php

namespace Cloudbooks\Member\Model;

use Cloudbooks\Common\Validator\ValidatorAbstract;

class MemberValidator extends ValidatorAbstract
{
    /**
     * @inheritDoc
     */
    public function isValid(array $data): bool
    {
        $name = $data['name'];
        $username = $data['username'];
        $password = $data['password'];

        if (3 >= strlen($name)) {
            $this->errors['name'] = $data['name'] . ' is not reaching our minimum length of 3 characters';
        }
        if (150 < strlen($name)) {
            $this->errors['name'] = substr($data['name'], 0, 150) . ' length is over our 150 character limit';
        }

        if (5 >= strlen($username)) {
            $this->errors['username'] = $data['username'] . ' is not reaching our minimum length of 3 characters';
        }
        if (150 < strlen($username)) {
            $this->errors['username'] = substr($data['username'], 0, 150) . ' length is over the 150 character limit';
        }
        if (false === ($username = filter_var($username, FILTER_VALIDATE_EMAIL))) {
            $this->errors['username'] = 'Could not validate ' . $data['username'] . ' being a valid email address';
        }

        if (8 >= strlen($password)) {
            $this->errors['password'] = 'Please use a password of minimum 8 characters';
        }

        return ([] === $this->errors);
    }
}
