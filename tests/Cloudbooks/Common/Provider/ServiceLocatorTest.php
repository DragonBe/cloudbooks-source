<?php

namespace Cloudbooks\Test\Common\Provider;

use Cloudbooks\Common\Interfaces\ServiceLocatorInterface;
use Cloudbooks\Common\Provider\ServiceLocator;

class ServiceLocatorTest extends \PHPUnit_Framework_TestCase
{
    public function testServiceLocatorImplementsInterface()
    {
        $serviceLocator = new ServiceLocator();
        $this->assertInstanceOf('\Cloudbooks\Common\Interfaces\ServiceLocatorInterface', $serviceLocator);
        return $serviceLocator;
    }

    /**
     * @depends testServiceLocatorImplementsInterface
     * @covers \Cloudbooks\Common\Provider\ServiceLocator::get
     */
    public function testServiceReturnsNullForNonExistingKeys(ServiceLocatorInterface $serviceLocator)
    {
        $this->assertNull($serviceLocator->get('\Foo\Bar'));
    }

    /**
     * @covers \Cloudbooks\Common\Provider\ServiceLocator::set
     * @expectedException \InvalidArgumentException
     */
    public function testServiceThrowsExceptionForMultiSettingOfData()
    {
        $serviceLocator = new ServiceLocator();

        $fooBar = new \stdClass();
        $fooBar->foo = 'bar';
        $fooBaz = new \stdClass();
        $fooBaz->foo = 'baz';

        $serviceLocator
            ->set('\Foo\Bar', $fooBar)
            ->set('\Foo\Bar', $fooBaz);

        $this->fail('Expected exception was not raised for double entries');

    }

    /**
     * @covers \Cloudbooks\Common\Provider\ServiceLocator::set
     * @covers \Cloudbooks\Common\Provider\ServiceLocator::get
     */
    public function testServiceCanRetrieveValues()
    {
        $serviceLocator = new ServiceLocator();

        $fooBar = new \stdClass();
        $fooBar->foo = 'bar';
        $fooBaz = new \stdClass();
        $fooBaz->foo = 'baz';

        $serviceLocator
            ->set('\Foo\Bar', $fooBar)
            ->set('\Foo\Baz', $fooBaz);

        $this->assertSame($fooBar, $serviceLocator->get('\Foo\Bar'));
        $this->assertSame($fooBaz, $serviceLocator->get('\Foo\Baz'));

    }
}