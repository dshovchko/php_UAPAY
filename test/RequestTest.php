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
class RequestWithFalseGetContents extends \UAPAY\Request
{
    public function file_get_contents($fname)
    {
        return false;
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

        $stub->data(array('test' => 'value'));

        $this->assertEquals(
            '{"params":[],"data":{"test":"value"}}',
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

        $stub->data(array('test' => 'value'));

        $this->assertEquals(
            '{"params":[],"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJwYXJhbXMiOltdLCJkYXRhIjp7InRlc3QiOiJ2YWx1ZSJ9LCJpYXQiOjE1MTAzMjY3Nzd9.fF8wEqCNmI7c5DZQ1hUkilBU5Ddd4gFVXyap6ZAMnYU7fSMWlimTYTQdFFOHJq6VXFrO5XoFGUjrOPsMs5zeDMSIZtSsPdiwFUP3JEtivTFPIJEWpQ0CcnUrehvwsHRpcd3qYWpXsfLXSdo9Oi0DYw04q157PDbEENuLaUTMHH_HbH_BD-OyLlmnSZeDyoJkYDVqepH7hmuEaLBqnpw3FUGUyH1hp88Onx2BMwNjXQrzOzHaj713S3pXiSPAyaMDyRanUYR_ugK0rtsCMCzIb1naCNDtMWVXXCRY1LSjKQ4bx7c6Z3mfa_z7v-559Zq9ePV5YtfcCzJewyPGAEMIRItV5fw2Iu2HK1YepudXr2tl0PjqrQOGvFQyzzgxr0OHd-4GfJk9Ddpad2m7WbFuhTx4vhKhPCJ7Mi1LGtCjvYDnlK_DiAg6FRU7ysNDofqdxGrJRk2IKSYc4fTo8PMdrYxvYwt6FWOXHTziuOpvQU9PkREy_x7IoVyE5lnmBhFinDdaQ9hrgEiqQhDCrVE98aYSgiRePcJVl81wMvulFHf5xN3BSOuEcZ_XvxU8-mCy2SuS0EQP5wAfV4lPlQy7UDIGtP3JQ7-bByfYJAVApsH7nksO6h93YRSmvtvjHGpnxOEulJ33fAJAQ6gAmJxAmdTmlJ5T3GXwH6bEuKtXRsY"}',
            $this->invokeMethod($stub, 'get_json', array(null))
        );
    }

    public function test_own_private_key()
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
            file_get_contents(dirname(__FILE__).'/files/php_UAPAY.private'),
            $this->invokeMethod($stub, 'own_private_key', array(null))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage The file with the private key was not find!
     */
    public function test_own_private_key_file_not_find()
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

        $this->invokeMethod($stub, 'own_private_key', array(null));
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage The file with the private key was not read!
     */
    public function test_own_private_key_file_not_read()
    {
        $stub = $this->getMockForAbstractClass(
            'UAPAYTest\RequestWithFalseGetContents',
            array(
                array(
                    'api_uri'=>'localhost',
                    'jwt'=>array(
                        'using'=>true,
                        'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
                        'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.private',
                    )))
        );

        $this->invokeMethod($stub, 'own_private_key', array(null));
    }

    public function test_token_encode()
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

        $payload = array(
            'params' => 'value',
            'iat' => '1234567890',
            'data' => ''
        );

        $this->assertEquals(
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJwYXJhbXMiOiJ2YWx1ZSIsImlhdCI6IjEyMzQ1Njc4OTAiLCJkYXRhIjoiIn0.ElJlq-pQzurrEMviRsw6gj8XOGeyw4325UCYpwTw-yVWSLDpd0mn3uUDjNkTKKKZqxZQwT3GrwojMxs62J-RF8gr7goLl_lmRvdvC8kXZ2k8I7mcak8gPoL8wKtX9tx8ir2Dh8arR1jiclaRoiPDnzZXSu2Apc7AbF0iTOmCnTdHNIH9G-MjXYA9Rdb8jUES-9xWe6f-py4cUsTtV3aHdKBe2LIs2ZBZMe7XFygS5Bm6Ws7_sl6tgS7cc4St7NfyYaIlIKPlta7aArPkCkPfG2rcXldyckeFMUS_zfw2QkalO5iVjcqZkh_5frUb2Epnx-TYHrgsCy9b32BWnhRrI7ZuQnC5ESGG0HkN6tQi2f2f_pndhB2PkChixJEKVtxaCU4HPUuMFnhnfdCBBD7Nft_ekYz_ne24JsTy2taqUXpQKxdF_j6FLiFHC889r5_M-tp4oC1-LqtTIB6juySFlftTBVrkoZBcc8iAzr9RvI2JG_dzNuZEom9CDNgNNybnXtoUnauQ9yAJ-iC3i-xdx-0fdDC0jHXMAblpEIdzh4qVXNyeEnJBpXaZOmrloG894pgkASORrPtm1FxcAW5OcFlsFLnpdGLmqcDgV7yjXYTbULedmRGwH9w5PO6O-rgwI9PFyApvrOkhZsRsD2GT4jflr0Dj7ZPRKt8vUbMZseY',
            $this->invokeMethod($stub, 'token_encode', array($payload))
        );

    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage unable to create JWT token
     */
    public function test_token_encode_bad_private_key()
    {
        $stub = $this->getMockForAbstractClass(
            'UAPAYTest\RequestWithConstantIAT',
            array(
                array(
                    'api_uri'=>'localhost',
                    'jwt'=>array(
                        'using'=>true,
                        'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
                        'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.bad',
                    )))
        );

        $payload = array(
            'params' => 'value',
            'iat' => '1234567890',
            'data' => ''
        );

        $this->assertEquals(
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJwYXJhbXMiOiJ2YWx1ZSIsImlhdCI6IjEyMzQ1Njc4OTAiLCJkYXRhIjoiIn0.ElJlq-pQzurrEMviRsw6gj8XOGeyw4325UCYpwTw-yVWSLDpd0mn3uUDjNkTKKKZqxZQwT3GrwojMxs62J-RF8gr7goLl_lmRvdvC8kXZ2k8I7mcak8gPoL8wKtX9tx8ir2Dh8arR1jiclaRoiPDnzZXSu2Apc7AbF0iTOmCnTdHNIH9G-MjXYA9Rdb8jUES-9xWe6f-py4cUsTtV3aHdKBe2LIs2ZBZMe7XFygS5Bm6Ws7_sl6tgS7cc4St7NfyYaIlIKPlta7aArPkCkPfG2rcXldyckeFMUS_zfw2QkalO5iVjcqZkh_5frUb2Epnx-TYHrgsCy9b32BWnhRrI7ZuQnC5ESGG0HkN6tQi2f2f_pndhB2PkChixJEKVtxaCU4HPUuMFnhnfdCBBD7Nft_ekYz_ne24JsTy2taqUXpQKxdF_j6FLiFHC889r5_M-tp4oC1-LqtTIB6juySFlftTBVrkoZBcc8iAzr9RvI2JG_dzNuZEom9CDNgNNybnXtoUnauQ9yAJ-iC3i-xdx-0fdDC0jHXMAblpEIdzh4qVXNyeEnJBpXaZOmrloG894pgkASORrPtm1FxcAW5OcFlsFLnpdGLmqcDgV7yjXYTbULedmRGwH9w5PO6O-rgwI9PFyApvrOkhZsRsD2GT4jflr0Dj7ZPRKt8vUbMZseY',
            $this->invokeMethod($stub, 'token_encode', array($payload))
        );

    }

}
