<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Key as Key;

class KeyTest extends TestCase
{
    public function test_get()
    {
        $k = new Key();
        $this->assertEquals(
            file_get_contents(dirname(__FILE__).'/files/php_UAPAY.private'),
            $k->get(dirname(__FILE__).'/files/php_UAPAY.private', 'private')
        );
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage not exists
     */
    public function test_get_notexists()
    {
        $k = new Key();
        $k->get(dirname(__FILE__).'/files/php_UAPAY.privkey', 'private');
    }

    public function test_check_exists()
    {
        $k = new Key();
        $this->invokeMethod($k, 'check_exists', array(dirname(__FILE__).'/files/php_UAPAY.public'));
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage not exists
     */
    public function test_check_exists_not()
    {
        $k = new Key();
        $this->invokeMethod($k, 'check_exists', array(dirname(__FILE__).'/files/php_UAPAY.pubkey'));
    }

    public function test_load()
    {
        $k = new Key();
        $this->assertEquals(
            file_get_contents(dirname(__FILE__).'/files/php_UAPAY.private'),
            $this->invokeMethod($k, 'load', array(dirname(__FILE__).'/files/php_UAPAY.private'))
        );
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage not read
     */
    public function test_load_not()
    {
        $k = new Key();
        $this->invokeMethod($k, 'load', array(dirname(__FILE__).'/files/php_UAPAY.pubkey'));
    }
}
