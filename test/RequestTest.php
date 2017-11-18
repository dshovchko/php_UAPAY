<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;

class RequestWithConstantIAT extends \UAPAY\Request
{
    public function get_param_iat()
    {
        return 1510326777;
    }
}

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

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/using is not specified
     */
    public function test_constructor_no_jwt_using()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost', 'jwt'=>1))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/using is not specified
     */
    public function test_constructor_no_jwt_using2()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost', 'jwt'=>array()))
        );

        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost', 'jwt'=>array('using'=>'21')))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/using is incorrect
     */
    public function test_constructor_incorrect_jwt_using()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost', 'jwt'=>array('using'=>'21')))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/UAPAY_pubkey is not specified
     */
    public function test_constructor_no_jwt_UAPAY_pubkey()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost', 'jwt'=>array('using'=>true)))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/our_privkey is not specified
     */
    public function test_constructor_no_jwt_our_privkey()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost', 'jwt'=>array('using'=>true, 'UAPAY_pubkey'=>'')))
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

    public function test_get_param_iat()
    {
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Request',
            array(array('api_uri'=>'localhost'))
        );

        $this->assertEquals(
            time(),
            $this->invokeMethod($stub, 'get_param_iat', array(null))
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

    public function test_get_json_with_token()
    {
        $stub = $this->getMockForAbstractClass(
            'UAPAYTest\RequestWithConstantIAT',
            array(
                array(
                    'api_uri'=>'localhost',
                    'jwt'=>array(
                        'using'=>true,
                        'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
                        'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.private',
                    )))
        );

        $this->assertEquals(
            '{"params":[],"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJwYXJhbXMiOltdLCJpYXQiOjE1MTAzMjY3Nzd9.FNcI7F4kmy2oktfIWGo6nMd2y6dZpTnl-xvbXzFTSAKBp6Z9G1UKvrBPPNxXYhUxOHsfY3QNzwowPQUKDAvXNM0HBE1JGj0EasAJsldXjxQO-4yPHZ5amCe2youwAqHKCGQqXt3r1QB1MG9N5h3pNP_k25j8BLFxhSxsDJfkRtVwEdhmQuHnO0S5p0SIDXPTdBnvOCKj5yOgY3WckjW8O7qMi2XPW49GtYWbM7phCxrEuyPS_-YKSIciFhoQswKZ3-sD4nPFBdmiS9j-17FrfshTustmGTvGcnYHWHnZH2I9sERnTI5t8p_Uao9uC8h3bxUYbfQDcus-H6ne1_WLJWFZkk3msnKeSVdVh2Mo2tikLUgg-hr1KmDHU7lo0kDuAku8IWK0Keht6bygCcmqEnK1u3NZiyBQKUVIUtiKoSyS7w_3fv3VWXt682EKu8x5rMW67zAcjrXe9ZUevL2ksOkl2TmgVMZaVhuIubJZLUbb3zuex88EgYCxo7PwtDbMEdfhMUT4m_3iL20uGwAZWnGfnP-ORwXfaPLdYgoeXBff3tamK8YSLGaMYqX60a2lK5LX6gBjY2S28c9L9cHoQZb2jPEVuD0Mb4bRw-ZS4aAuCoHjXrh0_N0pZN9Nx9HCks95EePMTh7EJ9wC7VSE0lpKQ2QfpwlDTecJZ_RQVI4"}',
            $this->invokeMethod($stub, 'get_json', array(null))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage The file with the private key was not find!
     */
    /*
    public function test_get_json_with_token_f1()
    {
        $stub = $this->getMockForAbstractClass(
            'UAPAYTest\RequestWithConstantIAT',
            array(
                array(
                    'api_uri'=>'localhost',
                    'jwt'=>array(
                        'using'=>true,
                        'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
                        'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.privkey',
                    )))
        );

        $this->invokeMethod($stub, 'get_json', array(null));
    }*/

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage unable to create JWT token
     */
    public function test_get_json_with_token_f2()
    {
        $stub = $this->getMockForAbstractClass(
            'UAPAYTest\RequestWithConstantIAT',
            array(
                array(
                    'api_uri'=>'localhost',
                    'jwt'=>array(
                        'using'=>true,
                        'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.pubkey',
                        'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.bad',
                    )))
        );

        $this->invokeMethod($stub, 'get_json', array(null));
    }
}
