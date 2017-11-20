<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\JWTOptions as JWTOptions;

class JWTOptionsTest extends TestCase
{
    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/using is not specified
     */
    public function test_constructor_no_jwt_using()
    {
        $jo = new JWTOptions(array('api_uri'=>'localhost', 'jwt'=>1));
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/using is not specified
     */
    public function test_constructor_no_jwt_using2()
    {
        $jo = new JWTOptions(array('api_uri'=>'localhost', 'jwt'=>array()));

        $jo = new JWTOptions(array('api_uri'=>'localhost', 'jwt'=>array('using'=>'21')));
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/using is incorrect
     */
    public function test_constructor_incorrect_jwt_using()
    {
        $jo = new JWTOptions(array('api_uri'=>'localhost', 'jwt'=>array('using'=>'21')));
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/UAPAY_pubkey is not specified
     */
    public function test_constructor_no_jwt_UAPAY_pubkey()
    {
        $jo = new JWTOptions(array('api_uri'=>'localhost', 'jwt'=>array('using'=>true)));
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/our_privkey is not specified
     */
    public function test_constructor_no_jwt_our_privkey()
    {
        $jo = new JWTOptions(array('api_uri'=>'localhost', 'jwt'=>array('using'=>true, 'UAPAY_pubkey'=>'')));
    }

    public function test_get()
    {
        $jo = new JWTOptions(array(
            'api_uri'=>'localhost',
            'jwt'=>array('using'=>true, 'UAPAY_pubkey'=>'public', 'our_privkey'=>'private')
        ));
        $this->assertEquals(
			array('using'=>true, 'UAPAY_pubkey'=>'public', 'our_privkey'=>'private'),
			$jo->get()
		);
    }

    public function test_get_without_jwt()
    {
        $jo = new JWTOptions(array(
            'api_uri'=>'localhost',

        ));
        $this->assertEquals(
			array('using'=>false, 'UAPAY_pubkey'=>'', 'our_privkey'=>''),
			$jo->get()
		);
    }
}