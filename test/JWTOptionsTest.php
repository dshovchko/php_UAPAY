<?php

namespace UAPAYTest;

use UAPAY\Key;
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

    public function test_is_valid_using()
    {
        $options = array(
            'api_uri'=>'localhost',
            'jwt'=>array('using'=>true, 'UAPAY_pubkey'=>'public', 'our_privkey'=>'private')
        );
        $jo = new JWTOptions($options);
        $payload = $this->invokeMethod($jo, 'is_valid_using', array($options));
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/using is incorrect
     */
    public function test_is_valid_using_bad_type()
    {
        $options = array(
            'api_uri'=>'localhost',
            'jwt'=>array('using'=>true, 'UAPAY_pubkey'=>'public', 'our_privkey'=>'private')
        );
        $jo = new JWTOptions($options);

        $options['jwt']['using'] = 1234;
        $payload = $this->invokeMethod($jo, 'is_valid_using', array($options));
    }

    public function test_is_present_option()
    {
        $options = array(
            'api_uri'=>'localhost',
            'jwt'=>array('using'=>true, 'UAPAY_pubkey'=>'public', 'our_privkey'=>'private')
        );
        $jo = new JWTOptions($options);
        $payload = $this->invokeMethod($jo, 'is_present_option', array($options, 'our_privkey'));
    }

    /**
     * @expectedException UAPAY\Exception\Data
     * @expectedExceptionMessage parameter jwt/our_privkey is not specified
     */
    public function test_is_present_option_not_present()
    {
        $options = array(
            'api_uri'=>'localhost',
            'jwt'=>array('using'=>true, 'UAPAY_pubkey'=>'public', 'our_privkey'=>'private')
        );
        $jo = new JWTOptions($options);

        unset($options['jwt']['our_privkey']);
        $payload = $this->invokeMethod($jo, 'is_present_option', array($options, 'our_privkey'));
    }

    public function test_get()
    {
        $jo = new JWTOptions(array(
            'api_uri'=>'localhost',
            'jwt'=>array('using'=>true, 'UAPAY_pubkey'=>'public', 'our_privkey'=>'private')
        ));
        $this->assertEquals(
			array('using'=>true, 'UAPAY_pubkey'=>'public', 'our_privkey'=>'private', 'algorithm' => 'RS512', 'key_type' => Key::KEYS_IN_FILES),
			$jo->get()
		);
    }

    public function test_get_without_jwt()
    {
        $jo = new JWTOptions(array(
            'api_uri'=>'localhost',

        ));
        $this->assertEquals(
			array('using'=>false, 'UAPAY_pubkey'=>'', 'our_privkey'=>'', 'key_type'=>'', 'algorithm'=>''),
			$jo->get()
		);
    }
}
