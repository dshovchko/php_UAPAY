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
                        'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.cer',
                        'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.ppk',
                    )))
        );

        $this->assertEquals(
            '{"params":[],"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJwYXJhbXMiOltdLCJpYXQiOjE1MTAzMjY3Nzd9.fmwDYEWRXTEjMOjPWipLJkqx5smLdMBlL8X7sjfI74XPbjQMD4XqgvktqRnDt6rA19Q01gbF6QOK1ROLj_OUWo5HtIN1KuwcGT-ii0pF0Lmet3prsuiyBPwSzAFhjAbijdTxYc00FtdX9oYpY_v8tbtMTNeh_0QWDsq4qzla95EoKMQzlubMvmjJwSNCgI6tZFGjflhi1EB9B6zhv0Smcsq_x2-fwbebru7OBCP6W7cI019XIm9gpPmWxmW4tUKnHRaoJkdIjurVY6XoblBWiOf9SQ0u4QBwQpBXkoLB7QDUTmnpPp3wSXhFA25DO9Q-EWbzNqcYp21CAIEMknRVloBDyIXDEZClHJI4f7zLpwacm5jOrlKbBJL4JeWpFvtpSkruTvXFQR5u14x7TMsi_dBlrdbm3BJKFZ2rCLl4yf0GhN3GEri8-C8HVSmn02OZxDxe3YIIyFzlYFVZRL3Entfrr46U4I0GzXd3849-35Ozr2LJgGpjSdx-1II74Ez9SLTf-zJ5RSj140Z-Et0PjL_-YatjlJbISeW2xHxrbxbATH5XvX23pyjTmK1VTxjyYUeWEnITq9CsmV05Eh074du57nKDuopsi0KJDzE1GfH84uqOhlB_5Q_KSLFv7Xb8ymqDpEyzSm5yhDPChPHvlhNqeAqQ7M4t9fWJR9SZVhE"}',
            $this->invokeMethod($stub, 'get_json', array(null))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage The file with the private key was not find!
     */
    public function test_get_json_with_token_f1()
    {
        $stub = $this->getMockForAbstractClass(
            'UAPAYTest\RequestWithConstantIAT',
            array(
                array(
                    'api_uri'=>'localhost',
                    'jwt'=>array(
                        'using'=>true,
                        'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.cer',
                        'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.ppk2',
                    )))
        );

        $this->invokeMethod($stub, 'get_json', array(null));
    }

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
                        'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.cer',
                        'our_privkey'=>dirname(__FILE__).'/files/php_bad.ppk',
                    )))
        );

        $this->invokeMethod($stub, 'get_json', array(null));
    }
}
