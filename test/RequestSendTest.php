<?php

namespace UAPAYTest;

use \UAPAYTest\TestCase;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class RequestWithMockHTTP extends \UAPAY\Request
{
    protected $api_path = '/api/path/';
    protected $response_class = '\UAPAY\Sessions\Create\Response';

    public function __construct() {}

    public function set_handler($mock)
    {
        $handler = HandlerStack::create($mock);

        $this->client = new \GuzzleHttp\Client([
            'handler'   => $handler,
            'base_uri'  => 'http://domain.org/',
        ]);
    }

    public function mock_200_ok()
    {
        return new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], '{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}'),
        ]);
    }

    public function mock_404()
    {
        return new MockHandler([
            new Response(404, ['Content-Length' => 0]),
        ]);
    }

    public function mock_500()
    {
        return new MockHandler([
            new Response(500, ['Content-Length' => 0]),
        ]);
    }

    public function mock_exception()
    {
        return new MockHandler([
            new RequestException("Error Communicating with Server", new Request('POST', $this->api_path))
        ]);
    }
}

class RequestSendTest extends TestCase
{
    public function test_send_ok()
    {

        $r = new RequestWithMockHTTP();
        $r->set_handler($r->mock_200_ok());

        $ret = $r->send();

        $this->assertInstanceOf(
            '\UAPAY\Sessions\Create\Response',
            $ret
        );
        $this->assertEquals(
            'a02822e2-6419-492b-857d-9aac9f1b615b',
            $ret->id()
        );
        $this->assertEquals(
            array('send request to /api/path/'),
            \UAPAY\Log::instance()->show_log()
        );
        $this->assertEquals(
            array(
                'build JSON:',
                '{"params":[]}',
                'got response:'.PHP_EOL.'{"status":1,"data":{"id":"a02822e2-6419-492b-857d-9aac9f1b615b"}}'),
            \UAPAY\Log::instance()->show_debug_log()
        );
    }

    /**
     * @expectedException UAPAY\Exception\Transfer
     * @expectedExceptionMessage an error occured during a transfer
     */
    public function test_send_404()
    {

        $r = new RequestWithMockHTTP();
        $r->set_handler($r->mock_404());

        $ret = $r->send();
    }

    /**
     * @expectedException UAPAY\Exception\Transfer
     * @expectedExceptionMessage an error occured during a transfer
     */
    public function test_send_500()
    {

        $r = new RequestWithMockHTTP();
        $r->set_handler($r->mock_500());

        $ret = $r->send();
    }

    /**
     * @expectedException UAPAY\Exception\Transfer
     * @expectedExceptionMessage an error occured during a transfer
     */
    public function test_send_exception()
    {

        $r = new RequestWithMockHTTP();
        $r->set_handler($r->mock_exception());

        $ret = $r->send();
    }
}
