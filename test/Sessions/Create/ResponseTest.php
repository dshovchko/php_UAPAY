<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Sessions\Create\Response as Response;

class SessionsCreateResponseTest extends TestCase
{
    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage data does not contain the id field!
     */
    public function test_constructor_nodataid_json()
    {
        $json = '{"status":1,"data":{"it":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $r = new Response($json);
    }

    public function test_id()
    {
        $json = '{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}';
        $r = new Response($json);

        $this->assertEquals(
            'a02822e2-6419-492b-857d-9aac9f1b615b',
            $r->id()
        );
    }
}
