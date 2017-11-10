<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Sessions\Create\Request as Request;

class SessionsCreateRequestTest extends TestCase
{
    public function test_api_path()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
        ));

        $this->assertEquals(
            '/api/sessions/create',
            $this->invokeProperty($r, 'api_path')->getValue($r)
        );
    }

    public function test_response_class()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
        ));

        $this->assertEquals(
            '\UAPAY\Sessions\Create\Response',
            $this->invokeProperty($r, 'response_class')->getValue($r)
        );
    }

    public function test_clientId()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
        ));

        $this->assertNULL($r->clientId());

        $this->assertEquals(
            '54',
            $r->clientId(54)
        );

        $this->assertEquals(
            '29.345',
            $r->clientId(29.345)
        );

        $this->assertEquals(
            's t r i n g',
            $r->clientId('s t r i n g')
        );
    }

    public function test_construct()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
        ));

        $this->assertNULL($r->clientId());

        $r = new Request(array(
            'api_uri' => 'localhost',
            'clientId' => '27',
        ));

        $this->assertEquals(
            '27',
            $r->clientId()
        );
    }

    public function test_get_params()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
            'clientId' => '27',
        ));

        $this->assertEquals(
            array(
                'clientId' => '27'
            ),
            $r->get_params()
        );
    }

    public function test_get_json()
    {
        $r = new Request(array(
            'api_uri' => 'localhost',
            'clientId' => '27',
        ));

        $this->assertEquals(
            '{"params":{"clientId":"27"}}',
            $r->get_json()
        );
    }
}
