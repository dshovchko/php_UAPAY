<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Orders\Create\Request as Request;

class OrdersCreateRequestTest extends TestCase
{
    public $options = array('api_uri' => 'localhost');

    public function test_api_path()
    {
        $r = new Request(
            $this->options
        );

        $this->assertEquals(
            '/api/orders/create',
            $this->invokeProperty($r, 'api_path')->getValue($r)
        );
    }

    public function test_response_class()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
        ));

        $this->assertEquals(
            '\UAPAY\Orders\Create\Response',
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

    public function test_construct()
    {
        $r = new Request(
            $this->options
        );
    }

    public function test_get_params()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
        ));
        $r->sessionId('f496f1cc-b4a3-4820-90a7-f803828286a1');

        $this->assertEquals(
            array(
                'sessionId' => 'f496f1cc-b4a3-4820-90a7-f803828286a1'
            ),
            $r->get_params()
        );
    }

    public function test_get_json()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
        ));
        $r->sessionId('f496f1cc-b4a3-4820-90a7-f803828286a1');

        $this->assertEquals(
            '{"params":{"sessionId":"f496f1cc-b4a3-4820-90a7-f803828286a1"}}',
            $r->get_json()
        );
    }
}
