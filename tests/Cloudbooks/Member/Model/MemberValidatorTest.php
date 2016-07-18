<?php

namespace Cloudbooks\Test\Member\Model;

use Cloudbooks\Member\Model\MemberValidator;

class MemberValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return MemberValidator
     * @covers \Cloudbooks\Member\Model\MemberValidator::__construct
     * @covers \Cloudbooks\Member\Model\MemberValidator::getErrors
     */
    public function testMemberValidatorIsInstantiatedWithEmptyArrayOfErrors()
    {
        $memberValidator = new MemberValidator();
        $this->assertSame([], $memberValidator->getErrors());
        return $memberValidator;
    }
    public function badDataProvider()
    {
        return [
            [
                '', '', '', [
                    'name' => '' . ' is not reaching our minimum length of 3 characters',
                    'username' => 'Could not validate ' . '' . ' being a valid email address',
                    'password' => 'Please use a password of minimum 8 characters',
                ],
            ],
            [
                'foo', 'bar', 'baz', [
                    'name' => 'foo' . ' is not reaching our minimum length of 3 characters',
                    'username' => 'Could not validate ' . 'bar' . ' being a valid email address',
                    'password' => 'Please use a password of minimum 8 characters',
                ],
            ],
            [
                str_repeat('a', 151), str_repeat('b', 151), str_repeat('c', 151), [
                    'name' => str_repeat('a', 150) . ' length is over our 150 character limit',
                    'username' => 'Could not validate ' . str_repeat('b', 151) . ' being a valid email address',
                ],
            ],
            [
                'John Doe', 'john.doe@example.com', '1234', [
                    'password' => 'Please use a password of minimum 8 characters',
                ],
            ],
            [
                'Jo', 'john.doe@example.com', '123456789', [
                    'name' => 'Jo' . ' is not reaching our minimum length of 3 characters',
                ],
            ],
            [
                'John Doe', 'john.doe@example', '123456789', [
                    'username' => 'Could not validate ' . 'john.doe@example' . ' being a valid email address',
                ],
            ]
        ];
    }

    /**
     * @param string $name
     * @param string $username
     * @param string $password
     * @param array $expectedErrors
     * @dataProvider badDataProvider
     * @covers \Cloudbooks\Member\Model\MemberValidator::isValid
     * @covers \Cloudbooks\Member\Model\MemberValidator::getErrors
     */
    public function testMemberValidationFailsWithWrongData(string $name, string $username, string $password, array $expectedErrors)
    {
        $data = [
            'name' => $name,
            'username' => $username,
            'password' => $password,
        ];

        $memberValidator = new MemberValidator();

        $errorCount = count($expectedErrors);

        $this->assertFalse($memberValidator->isValid($data));
        $this->assertCount($errorCount, $memberValidator->getErrors());
        $this->assertSame($expectedErrors, $memberValidator->getErrors());
    }

    public function goodDataProvider()
    {
        return [
            ['John Doe', 'john.doe@company.com', 'abcdEFG123!'],
            ['Madonna', 'me@madonna.com', 'L1k3 A verg1n#'],
        ];
    }

    /**
     * @param string $name
     * @param string $username
     * @param string $password
     * @dataProvider goodDataProvider
     * @covers \Cloudbooks\Member\Model\MemberValidator::__construct
     * @covers \Cloudbooks\Member\Model\MemberValidator::isValid
     */
    public function testMemberValidationSucceedsWithCorrectData(string $name, string $username, string $password)
    {
        $data = [
            'name' => $name,
            'username' => $username,
            'password' => $password,
        ];
        $memberValidator = new MemberValidator();
        $this->assertTrue($memberValidator->isValid($data));
    }
}