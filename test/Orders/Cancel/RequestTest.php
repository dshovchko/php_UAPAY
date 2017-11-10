<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Orders\Cancel\Request as Request;

class OrdersCancelRequestTest extends TestCase
{
    public $options = array('api_uri' => 'localhost', 'clientId' => '27',);

    public function test_api_path()
    {
        $r = new Request(
            $this->options
        );

        $this->assertEquals(
            '/api/orders/cancel',
            $this->invokeProperty($r, 'api_path')->getValue($r)
        );
    }

    public function test_response_class()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
        ));

        $this->assertEquals(
            '\UAPAY\Orders\Cancel\Response',
            $this->invokeProperty($r, 'response_class')->getValue($r)
        );
    }

    public function test_sessionId()
    {
        $r = new Request(
            $this->options
        );

        $this->assertNULL($r->sessionId());

        $this->assertEquals(
            '54',
            $r->sessionId(54)
        );

        $this->assertEquals(
            '29.345',
            $r->sessionId(29.345)
        );

        $this->assertEquals(
            's t r i n g',
            $r->sessionId('s t r i n g')
        );
    }

    public function test_id()
    {
        $r = new Request(
            $this->options
        );

        $this->assertNULL(
            $r->id()
        );

        $this->assertEquals(
            '54',
            $r->id(54)
        );

        $this->assertEquals(
            '29.345',
            $r->id(29.345)
        );

        $this->assertEquals(
            's t r i n g',
            $r->id('s t r i n g')
        );
    }

    public function test_construct()
    {
        $r = new Request(
            $this->options
        );

        $this->assertNULL(
            $r->id()
        );
    }

    public function test_get_json()
    {
        $r = new Request(
            $this->options
        );
        $r->sessionId('0c5ba5dc-261a-4b4b-b9f3-3d859ac9c97c');
        $r->id('6d347646-cc03-4e2f-bb2a-f1ba197f62e1');

        $this->assertEquals(
            '{"params":{"id":"6d347646-cc03-4e2f-bb2a-f1ba197f62e1","sessionId":"0c5ba5dc-261a-4b4b-b9f3-3d859ac9c97c"}}',
            $r->get_json()
        );
    }
}
