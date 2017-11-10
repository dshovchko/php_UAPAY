<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;

class RequestTest extends TestCase
{
    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter api_uri is not specified
     */
    public function test_constructor_no_api_uri()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array())
        );
    }

    public function test_as_string()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost'))
        );

        // Array
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_string', array(array(39)))
        );

        // Bool true
        $this->assertEquals(
            'true',
            $this->invokeMethod($stub, 'as_string', array(true))
        );

        // Bool false
        $this->assertEquals(
            'false',
            $this->invokeMethod($stub, 'as_string', array(false))
        );

        // Float
        $this->assertEquals(
            '83.529',
            $this->invokeMethod($stub, 'as_string', array(83.529))
        );

        // Integer
        $this->assertEquals(
            '54',
            $this->invokeMethod($stub, 'as_string', array(54))
        );

        // Object
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_string', array(new \stdClass()))
        );

        // NULL
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_string', array(null))
        );

        // String
        $this->assertEquals(
            ' t E x t ',
            $this->invokeMethod($stub, 'as_string', array(' t E x t '))
        );
    }

    public function test_as_int()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost'))
        );

        // Array
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_int', array(array(39)))
        );

        // Bool true
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_int', array(true))
        );

        // Bool false
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_int', array(false))
        );

        // Float
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_int', array(83.529))
        );

        // Integer
        $this->assertEquals(
            '54',
            $this->invokeMethod($stub, 'as_int', array(54))
        );

        // Object
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_int', array(new \stdClass()))
        );

        // NULL
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_int', array(null))
        );

        // String
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_int', array(' t E x t '))
        );
    }

    public function test_as_array()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost'))
        );

        // Array
        $this->assertEquals(
            array(39),
            $this->invokeMethod($stub, 'as_array', array(array(39)))
        );

        // Bool true
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_array', array(true))
        );

        // Bool false
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_array', array(false))
        );

        // Float
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_array', array(83.529))
        );

        // Integer
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_array', array(54))
        );

        // Object
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_array', array(new \stdClass()))
        );

        // NULL
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_array', array(null))
        );

        // String
        $this->assertNULL(
            $this->invokeMethod($stub, 'as_int', array(' t E x t '))
        );
    }

    public function test_data()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost'))
        );

        $this->assertNULL(
            $this->invokeMethod($stub, 'data', array(null))
        );

        $this->assertEquals(
            array(39),
            $this->invokeMethod($stub, 'data', array(array(39)))
        );

        $this->assertEquals(
            array('i'=>'j',1=>2),
            $this->invokeMethod($stub, 'data', array(array('i'=>'j',1=>2)))
        );
    }

    public function test_get_params()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost'))
        );

        $this->assertEquals(
            array(),
            $this->invokeMethod($stub, 'get_params', array(null))
        );
    }

    public function test_get_json()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost'))
        );

        $this->assertEquals(
            '{"params":[]}',
            $this->invokeMethod($stub, 'get_json', array(null))
        );
    }
}
