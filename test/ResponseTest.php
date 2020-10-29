<?php

namespace UAPAYTest;

use UAPAY\Key;
use \UAPAYTest\TestCase;

class ResponseForTesting extends \UAPAY\Response
{
    public function __construct($jwt_options=null)
    {
        if (isset($jwt_options) && is_array($jwt_options))
        {
            $this->jwt = array_merge($this->jwt, $jwt_options);
        }
    }

    public function set_json($json_string)
    {
        $this->json = $this->json_decode($json_string);
    }
}

class ResponseTest extends TestCase
{
    public function test_constructor()
    {
        $json = '{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $options = array(
            'using'=>false,
            'UAPAY_pubkey'=>'/files/php_UAPAY.public',
            'our_privkey'=>'/files/php_UAPAY.private',
            'key_type'=>Key::KEYS_IN_FILES,
            'algorithm'=>'RS512',
        );
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json, $options)
        );

        $this->assertEquals(
            array(
                'using'         => false,
                'UAPAY_pubkey'  => '/files/php_UAPAY.public',
                'our_privkey'   => '/files/php_UAPAY.private',
                'key_type'      => Key::KEYS_IN_FILES,
                'algorithm'     => 'RS512',
            ),
            $this->invokeProperty($stub, 'jwt')->getValue($stub)
        );
    }

    public function test_constructor_without_jwt()
    {
        $json = '{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );

        $this->assertEquals(
            array(
                'using'         => false,
                'UAPAY_pubkey'  => '',
                'our_privkey'   => '',
                'key_type'      => '',
                'algorithm'     => '',
            ),
            $this->invokeProperty($stub, 'jwt')->getValue($stub)
        );
    }

    public function test_json_decode()
    {
        $json = '{"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $r = new ResponseForTesting(array());
        $this->assertEquals(
            array(
                'data' => array('id' => 'a02822e2-6419-492b-857d-9aac9f1b615b')
            ),
            $this->invokeMethod($r, 'json_decode', array($json))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage decoding error of the json response!
     */
    public function test_json_decode_fail()
    {
        $json = '{{"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $r = new ResponseForTesting(array());
        $this->invokeMethod($r, 'json_decode', array($json));
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json contain an error message!
     */
    public function test_json_handle_contain_error()
    {
        $json = '{"error":{"fields":{"params":{"clientId":"REQUIRED"}},"code":"FORMAT_ERROR"}}';
        $r = new ResponseForTesting(array());
        $r->set_json($json);
        $this->invokeMethod($r, 'json_handle', array(null));
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json response!
     */
    public function test_json_handle_with_nostatus()
    {
        $json = '{"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $r = new ResponseForTesting(array());
        $r->set_json($json);
        $this->invokeMethod($r, 'json_handle', array(null));
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json response contain an error status!
     */
    public function test_json_handle_with_wrong_status()
    {
        $json = '{"status":0}';
        $r = new ResponseForTesting(array());
        $r->set_json($json);
        $this->invokeMethod($r, 'json_handle', array(null));
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json does not contain the data field!
     */
    public function test_json_handle_without_data()
    {
        $json = '{"status":1,"dota":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $r = new ResponseForTesting(array());
        $r->set_json($json);
        $this->invokeMethod($r, 'json_handle', array(null));
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json does not contain the data field!
     */
    public function test_json_handle_with_invalid_data()
    {
        $json = '{"status":1,"data":1}';
        $r = new ResponseForTesting(array());
        $r->set_json($json);
        $this->invokeMethod($r, 'json_handle', array(null));
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage data does not contain the token field!
     */
    public function test_json_handle_without_token()
    {
        $options = array(
            'using'=>true,
            'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
            'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.private',
        );
        $json = '{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $r = new ResponseForTesting($options);
        $r->set_json($json);
        $this->invokeMethod($r, 'json_handle', array(null));
    }

    public function test_json_handle_with_token()
    {
        $options = array(
            'using'=>true,
            'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
            'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.private',
            'key_type'=>Key::KEYS_IN_FILES,
            'algorithm'=>'RS512',
        );
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJwYXJhbXMiOltdLCJkYXRhIjp7InRlc3QiOiJ2YWx1ZSJ9LCJpYXQiOjE1MTAzMjY3Nzd9.fF8wEqCNmI7c5DZQ1hUkilBU5Ddd4gFVXyap6ZAMnYU7fSMWlimTYTQdFFOHJq6VXFrO5XoFGUjrOPsMs5zeDMSIZtSsPdiwFUP3JEtivTFPIJEWpQ0CcnUrehvwsHRpcd3qYWpXsfLXSdo9Oi0DYw04q157PDbEENuLaUTMHH_HbH_BD-OyLlmnSZeDyoJkYDVqepH7hmuEaLBqnpw3FUGUyH1hp88Onx2BMwNjXQrzOzHaj713S3pXiSPAyaMDyRanUYR_ugK0rtsCMCzIb1naCNDtMWVXXCRY1LSjKQ4bx7c6Z3mfa_z7v-559Zq9ePV5YtfcCzJewyPGAEMIRItV5fw2Iu2HK1YepudXr2tl0PjqrQOGvFQyzzgxr0OHd-4GfJk9Ddpad2m7WbFuhTx4vhKhPCJ7Mi1LGtCjvYDnlK_DiAg6FRU7ysNDofqdxGrJRk2IKSYc4fTo8PMdrYxvYwt6FWOXHTziuOpvQU9PkREy_x7IoVyE5lnmBhFinDdaQ9hrgEiqQhDCrVE98aYSgiRePcJVl81wMvulFHf5xN3BSOuEcZ_XvxU8-mCy2SuS0EQP5wAfV4lPlQy7UDIGtP3JQ7-bByfYJAVApsH7nksO6h93YRSmvtvjHGpnxOEulJ33fAJAQ6gAmJxAmdTmlJ5T3GXwH6bEuKtXRsY';
        $json = '{"status":1,"data":{"token":"'.$token.'"}}';
        $r = new ResponseForTesting($options);
        $r->set_json($json);
        $this->invokeMethod($r, 'json_handle', array(null));

        $this->assertEquals(
            array(
                'params' => array(),
                'data' => (object)['test' => 'value'],
                'iat' => 1510326777
            ),
            $this->invokeProperty($r, 'json')->getValue($r)['data']
        );

        $this->assertEquals(
            1,
            $r->status()
        );
    }

    public function test_uapay_public_key()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJwYXJhbXMiOltdLCJkYXRhIjp7InRlc3QiOiJ2YWx1ZSJ9LCJpYXQiOjE1MTAzMjY3Nzd9.fF8wEqCNmI7c5DZQ1hUkilBU5Ddd4gFVXyap6ZAMnYU7fSMWlimTYTQdFFOHJq6VXFrO5XoFGUjrOPsMs5zeDMSIZtSsPdiwFUP3JEtivTFPIJEWpQ0CcnUrehvwsHRpcd3qYWpXsfLXSdo9Oi0DYw04q157PDbEENuLaUTMHH_HbH_BD-OyLlmnSZeDyoJkYDVqepH7hmuEaLBqnpw3FUGUyH1hp88Onx2BMwNjXQrzOzHaj713S3pXiSPAyaMDyRanUYR_ugK0rtsCMCzIb1naCNDtMWVXXCRY1LSjKQ4bx7c6Z3mfa_z7v-559Zq9ePV5YtfcCzJewyPGAEMIRItV5fw2Iu2HK1YepudXr2tl0PjqrQOGvFQyzzgxr0OHd-4GfJk9Ddpad2m7WbFuhTx4vhKhPCJ7Mi1LGtCjvYDnlK_DiAg6FRU7ysNDofqdxGrJRk2IKSYc4fTo8PMdrYxvYwt6FWOXHTziuOpvQU9PkREy_x7IoVyE5lnmBhFinDdaQ9hrgEiqQhDCrVE98aYSgiRePcJVl81wMvulFHf5xN3BSOuEcZ_XvxU8-mCy2SuS0EQP5wAfV4lPlQy7UDIGtP3JQ7-bByfYJAVApsH7nksO6h93YRSmvtvjHGpnxOEulJ33fAJAQ6gAmJxAmdTmlJ5T3GXwH6bEuKtXRsY';
        $json = '{"status":1,"data":{"token":"'.$token.'"}}';
        $options = array(
            'using'=>true,
            'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
            'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.private',
            'key_type'=>Key::KEYS_IN_FILES,
            'algorithm'=>'RS512',
        );
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json, $options)
        );

        $this->assertEquals(
            file_get_contents(dirname(__FILE__).'/files/php_UAPAY.public'),
            $this->invokeMethod($stub, 'uapay_public_key', array(null))
        );
    }

    public function test_token_decode()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJwYXJhbXMiOltdLCJkYXRhIjp7InRlc3QiOiJ2YWx1ZSJ9LCJpYXQiOjE1MTAzMjY3Nzd9.fF8wEqCNmI7c5DZQ1hUkilBU5Ddd4gFVXyap6ZAMnYU7fSMWlimTYTQdFFOHJq6VXFrO5XoFGUjrOPsMs5zeDMSIZtSsPdiwFUP3JEtivTFPIJEWpQ0CcnUrehvwsHRpcd3qYWpXsfLXSdo9Oi0DYw04q157PDbEENuLaUTMHH_HbH_BD-OyLlmnSZeDyoJkYDVqepH7hmuEaLBqnpw3FUGUyH1hp88Onx2BMwNjXQrzOzHaj713S3pXiSPAyaMDyRanUYR_ugK0rtsCMCzIb1naCNDtMWVXXCRY1LSjKQ4bx7c6Z3mfa_z7v-559Zq9ePV5YtfcCzJewyPGAEMIRItV5fw2Iu2HK1YepudXr2tl0PjqrQOGvFQyzzgxr0OHd-4GfJk9Ddpad2m7WbFuhTx4vhKhPCJ7Mi1LGtCjvYDnlK_DiAg6FRU7ysNDofqdxGrJRk2IKSYc4fTo8PMdrYxvYwt6FWOXHTziuOpvQU9PkREy_x7IoVyE5lnmBhFinDdaQ9hrgEiqQhDCrVE98aYSgiRePcJVl81wMvulFHf5xN3BSOuEcZ_XvxU8-mCy2SuS0EQP5wAfV4lPlQy7UDIGtP3JQ7-bByfYJAVApsH7nksO6h93YRSmvtvjHGpnxOEulJ33fAJAQ6gAmJxAmdTmlJ5T3GXwH6bEuKtXRsY';
        $json = '{"status":1,"data":{"token":"'.$token.'"}}';
        $options = array(
            'using'=>true,
            'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
            'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.private',
            'key_type'=>Key::KEYS_IN_FILES,
            'algorithm'=>'RS512',
        );
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json, $options)
        );

        $this->assertEquals(
            array(
                'params' => array(),
                'data' => (object)['test' => 'value'],
                'iat' => 1510326777
            ),
            $this->invokeMethod($stub, 'token_decode', array($token))
        );
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage unable to decode JWT token
     */
    public function test_token_decode_failed()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiOltdLCJkYXRhIjp7InRlc3QiOiJ2YWx1ZSJ9LCJpYXQiOjE1MTAzMjY3Nzd9.fF8wEqCNmI7c5DZQ1hUkilBU5Ddd4gFVXyap6ZAMnYU7fSMWlimTYTQdFFOHJq6VXFrO5XoFGUjrOPsMs5zeDMSIZtSsPdiwFUP3JEtivTFPIJEWpQ0CcnUrehvwsHRpcd3qYWpXsfLXSdo9Oi0DYw04q157PDbEENuLaUTMHH_HbH_BD-OyLlmnSZeDyoJkYDVqepH7hmuEaLBqnpw3FUGUyH1hp88Onx2BMwNjXQrzOzHaj713S3pXiSPAyaMDyRanUYR_ugK0rtsCMCzIb1naCNDtMWVXXCRY1LSjKQ4bx7c6Z3mfa_z7v-559Zq9ePV5YtfcCzJewyPGAEMIRItV5fw2Iu2HK1YepudXr2tl0PjqrQOGvFQyzzgxr0OHd-4GfJk9Ddpad2m7WbFuhTx4vhKhPCJ7Mi1LGtCjvYDnlK_DiAg6FRU7ysNDofqdxGrJRk2IKSYc4fTo8PMdrYxvYwt6FWOXHTziuOpvQU9PkREy_x7IoVyE5lnmBhFinDdaQ9hrgEiqQhDCrVE98aYSgiRePcJVl81wMvulFHf5xN3BSOuEcZ_XvxU8-mCy2SuS0EQP5wAfV4lPlQy7UDIGtP3JQ7-bByfYJAVApsH7nksO6h93YRSmvtvjHGpnxOEulJ33fAJAQ6gAmJxAmdTmlJ5T3GXwH6bEuKtXRsY';
        $json = '{"status":1,"data":{"token":"'.$token.'"}}';
        $options = array(
            'using'=>true,
            'UAPAY_pubkey'=>dirname(__FILE__).'/files/php_UAPAY.public',
            'our_privkey'=>dirname(__FILE__).'/files/php_UAPAY.private',
        );
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json, $options)
        );

        $this->assertEquals(
            array(
                'params' => array(),
                'data' => (object)['test' => 'value'],
                'iat' => 1510326777
            ),
            $this->invokeMethod($stub, 'token_decode', array($token))
        );
    }

    public function test_status()
    {
        $json = '{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $stub = $this->getMockForAbstractClass(
            '\UAPAY\Response',
            array($json)
        );

        $this->assertEquals(
            1,
            $stub->status()
        );
    }

}
