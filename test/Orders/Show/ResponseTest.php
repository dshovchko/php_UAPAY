<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Orders\Show\Response as Response;

class OrdersShowResponseTest extends TestCase
{
    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage data does not contain the id field!
     */
    public function test_constructor_nodataid_json()
    {
        $json = '{"status":1,"data":{"it":"5621bbb6-b5cb-4f1f-a420-a989fa998b56","paymentPageUrl":"http://pay.demo.uapay.ua/payment/5621bbb6-b5cb-4f1f-a420-a989fa998b56"}}';
        $r = new Response($json);
    }

    public function test_id()
    {
        $json = '{"status":1,"data":{"id":"5621bbb6-b5cb-4f1f-a420-a989fa998b56","name":"test name","clientId":27}}';
        $r = new Response($json);

        $this->assertEquals(
            '5621bbb6-b5cb-4f1f-a420-a989fa998b56',
            $r->id()
        );
    }

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
