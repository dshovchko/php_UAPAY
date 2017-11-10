<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Orders\Cancel\Response as Response;

class OrdersCancelResponseTest extends TestCase
{
    public function test_data()
    {
        $json = '{"status":1,"data":{"id":"5621bbb6-b5cb-4f1f-a420-a989fa998b56","name":"test name","clientId":27,"currency":980}}';
        $r = new Response($json);

        $this->assertEquals(
            array(
                'id'=>'5621bbb6-b5cb-4f1f-a420-a989fa998b56',
                'name' => 'test name',
                'clientId' => 27,
                'currency' => 980
            ),
            $r->data()
        );
    }
}
