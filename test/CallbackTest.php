<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Callback as Callback;

class CallbackTest extends TestCase
{
    public function SetUp()
    {
        $existed = in_array('php', stream_get_wrappers());
        if ($existed) {
            stream_wrapper_unregister('php');
        }
        stream_wrapper_register('php', '\UAPAYTest\MockPHPStream');

        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        parent::SetUp();
    }

    public function TearDown()
    {
        stream_wrapper_restore('php');

        parent::TearDown();
    }

    public function JSON_ok()
    {
        return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
    }

    public function JSON_bad()
	{
		return '{';
    }

    public function JSON_error()
    {
        return '{"status":0,"error":{"fields":{"params":{"clientId":"REQUIRED"}},"code":"FORMAT_ERROR"}}';
    }

    public function JSON_without_Status()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"statuZ":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
    }

    public function JSON_without_Id()
	{
		return '{"it":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
    }

    public function JSON_without_OrderId()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderIt":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
    }

    public function JSON_without_Number()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number2":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
    }

    public function JSON_without_CreatedAt()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdZ":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
    }

    public function JSON_without_Amount()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amound":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
    }

    /**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage decoding error of the json callback!
     */
	public function test_construct_JSON_bad()
	{
        file_put_contents('php://input', $this->JSON_bad());
		$c = new Callback();
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json callback contain an error message!
     */
    public function test_construct_JSON_error()
    {
        file_put_contents('php://input', $this->JSON_error());
        $c = new Callback();
    }

    /**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_status()
	{
        file_put_contents('php://input', $this->JSON_without_Status());
		$c = new Callback();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_id()
	{
        file_put_contents('php://input', $this->JSON_without_Id());
		$c = new Callback();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_orderId()
	{
        file_put_contents('php://input', $this->JSON_without_OrderId());
		$c = new Callback();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_number()
	{
        file_put_contents('php://input', $this->JSON_without_Number());
		$c = new Callback();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_amount()
	{
        file_put_contents('php://input', $this->JSON_without_Amount());
		$c = new Callback();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_createdAt()
	{
        file_put_contents('php://input', $this->JSON_without_CreatedAt());
		$c = new Callback();
	}

    public function test_status()
	{
        file_put_contents('php://input', $this->JSON_ok());
		$c = new Callback();
		$this->assertEquals(
			'FINISHED',
			$c->status()
		);
    }

    public function test_id()
	{
        file_put_contents('php://input', $this->JSON_ok());
		$c = new Callback();
		$this->assertEquals(
			'b9291adc-45a4-4ce4-a30a-ed76aa4bb14a',
			$c->id()
		);
	}

	public function test_orderId()
	{
        file_put_contents('php://input', $this->JSON_ok());
		$c = new Callback();
		$this->assertEquals(
			'c4957592-f23c-419e-bcaf-219d2e145b5a',
			$c->orderId()
		);
	}

	public function test_number()
	{
        file_put_contents('php://input', $this->JSON_ok());
		$c = new Callback();
		$this->assertEquals(
			7952,
			$c->number()
		);
	}

	public function test_amount()
	{
        file_put_contents('php://input', $this->JSON_ok());
		$c = new Callback();
		$this->assertEquals(
			1234,
			$c->amount()
		);
	}

	public function test_createdAt()
	{
        file_put_contents('php://input', $this->JSON_ok());
		$c = new Callback();
		$this->assertEquals(
			'1510134928000',
			$c->createdAt()
		);
	}

	public function test_json()
	{
        file_put_contents('php://input', $this->JSON_ok());
		$c = new Callback();
		$this->assertEquals(
			array(
				'id' => 'b9291adc-45a4-4ce4-a30a-ed76aa4bb14a',
				'orderId' => 'c4957592-f23c-419e-bcaf-219d2e145b5a',
				'externalId' => '24',
				'number' => 7952,
				'paymentNumber' => 7952,
				'extarnalId' => '24',
				'cardPanMasked' => '5351360971',
				'amount' => 1234,
				'status' => 'FINISHED',
				'paymentStatus' => 'FINISHED',
				'extraInfo' => '{}',
				'receiptPath' => '/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf',
				'createdAt' => '1510134928000',
				'createDate' => '1510134928000',
				'payDate' => '1510135081998'
			),
			$c->json()
		);
    }

    public function test_get_http_raw_post_data()
    {
        file_put_contents('php://input', $this->JSON_ok());
        $c = new Callback();

        \UAPAY\Log::set(new \Debulog\MockLogger());
        file_put_contents('php://input', 'some raw text');
        $this->assertEquals(
            'some raw text',
            $this->invokeMethod($c, 'get_http_raw_post_data', array(null))
        );

        $this->assertEquals(
            array('callback request from 1.2.3.4'),
            \UAPAY\Log::instance()->show_log()
        );
        $this->assertEquals(
            array('got: ', 'some raw text',' '),
            \UAPAY\Log::instance()->show_debug_log()
        );
    }
}
