<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;
use \UAPAY\Callback as Callback;

class CallbackOk extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
	}
}

class CallbackOkTest extends TestCase
{
	public function test_status()
	{
		$c = new CallbackOk();
		$this->assertEquals(
			'FINISHED',
			$c->status()
		);
	}

	public function test_id()
	{
		$c = new CallbackOk();
		$this->assertEquals(
			'b9291adc-45a4-4ce4-a30a-ed76aa4bb14a',
			$c->id()
		);
	}

	public function test_orderId()
	{
		$c = new CallbackOk();
		$this->assertEquals(
			'c4957592-f23c-419e-bcaf-219d2e145b5a',
			$c->orderId()
		);
	}

	public function test_number()
	{
		$c = new CallbackOk();
		$this->assertEquals(
			7952,
			$c->number()
		);
	}

	public function test_amount()
	{
		$c = new CallbackOk();
		$this->assertEquals(
			1234,
			$c->amount()
		);
	}

	public function test_createdAt()
	{
		$c = new CallbackOk();
		$this->assertEquals(
			'1510134928000',
			$c->createdAt()
		);
	}

	public function test_json()
	{
		$c = new CallbackOk();
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
}

class CallbackBadJSON extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{';
	}
}

class CallbackBadJSONTest extends TestCase
{
	/**
     * @expectedException UAPAY\Exception\Runtime
     * @expectedExceptionMessage decoding error of the json callback!
     */
	public function test_construct()
	{
		$c = new CallbackBadJSON();
	}
}

class CallbackErrorJSON extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{"status":0,"error":{"fields":{"params":{"clientId":"REQUIRED"}},"code":"FORMAT_ERROR"}}';
	}
}

class CallbackErrorJSONTest extends TestCase
{
	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage json callback contain an error message!
     */
	public function test_construct()
	{
		$c = new CallbackErrorJSON();
	}
}

class CallbackJSONwithoutStatus extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"statuZ":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
	}
}

class CallbackJSONwithoutId extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{"it":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
	}
}

class CallbackJSONwithoutOrderId extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderIt":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
	}
}

class CallbackJSONwithoutNumber extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number2":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
	}
}

class CallbackJSONwithoutCreatedAt extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amount":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdZ":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
	}
}

class CallbackJSONwithoutAmount extends Callback
{
	protected function get_http_raw_post_data()
	{
		return '{"id":"b9291adc-45a4-4ce4-a30a-ed76aa4bb14a","orderId":"c4957592-f23c-419e-bcaf-219d2e145b5a","externalId":"24","number":7952,"paymentNumber":7952,"extarnalId":"24","cardPanMasked":"5351360971","amound":1234,"status":"FINISHED","paymentStatus":"FINISHED","extraInfo":"{}","receiptPath":"/acquiring/receipts/ab20aed7-92ff-4b41-a938-5afe26dc91e1.pdf","createdAt":"1510134928000","createDate":"1510134928000","payDate":"1510135081998"}';
	}
}

class CallbackPartialJSONTest extends TestCase
{
	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_status()
	{
		$c = new CallbackJSONwithoutStatus();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_id()
	{
		$c = new CallbackJSONwithoutId();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_orderId()
	{
		$c = new CallbackJSONwithoutOrderId();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_number()
	{
		$c = new CallbackJSONwithoutNumber();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_amount()
	{
		$c = new CallbackJSONwithoutAmount();
	}

	/**
     * @expectedException UAPAY\Exception\JSON
     * @expectedExceptionMessage invalid json callback!
     */
	public function test_without_createdAt()
	{
		$c = new CallbackJSONwithoutCreatedAt();
	}
}
