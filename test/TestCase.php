<?php

/**
 *      Test case
 *
 *      @package php_UAPAY
 *      @version 1.0
 *      @author Dmitry Shovchko <d.shovchko@gmail.com>
 */

namespace UAPAYTest;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        \UAPAY\Log::set(new \Debulog\StubLogger(''));
    }

    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public function invokeProperty(&$object, $propertyName) {
		$reflection = new \ReflectionClass(get_class($object));
		$property = $reflection->getProperty($propertyName);
		$property->setAccessible(true);

		return $property;
	}
}
