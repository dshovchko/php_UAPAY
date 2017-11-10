<?php

namespace UAPAY;

use UAPAY\Log as Log;
use UAPAY\Exception;

class Callback
{
    /**
     *      @var String
     */
    protected $json;

    /**
     *      @var String
     */
    protected $id;

    /**
     *      @var String
     */
    protected $orderId;

    /**
     *      @var Int
     */
    protected $number;

    /**
     *      @var amount
     */
    protected $amount;

    /**
     *      @var String
     */
    protected $createdAt;

    /**
     *      Constructor
     *
     *      @param array $json_string array of options
     */
    public function __construct()
    {
        $json_string = $this->get_http_raw_post_data();

        $this->json = json_decode($json_string, true);
        if (json_last_error() != 0)
        {
            throw new Exception\Runtime('decoding error of the json callback!');
        }

        if (isset($this->json['error']))
        {
            throw new Exception\JSON('json callback contain an error message!');
        }

        $this->status = $this->json_value('status');
        $this->id = $this->json_value('id');
        $this->orderId = $this->json_value('orderId');
        $this->number = $this->json_value('number');
        $this->amount = $this->json_value('amount');
        $this->createdAt = $this->json_value('createdAt');
    }

    /**
     *      Get data from the body of the http request
     *
     *      - with the appropriate configuration of php.ini they can be found
     *        in the global variable $HTTP_RAW_POST_DATA
     *
     *      - but it's easier just to read the data from the php://input stream,
     *        which does not depend on the php.ini directives and allows you to read
     *        raw data from the request body
     *
     *      @return string Http raw post data
     *
     */
    protected function get_http_raw_post_data()
    {
        Log::instance()->add('callback request from ' . $_SERVER['REMOTE_ADDR']);

        $raw_request = file_get_contents('php://input');

        Log::instance()->debug('got: ');
        Log::instance()->debug($raw_request);
        Log::instance()->debug(' ');

        return $raw_request;
    }

    /**
     *      Get value from JSON
     *
     *      @param $name String
     *      @return String
     */
    protected function json_value($name)
    {
        if (!isset($this->json[$name]))
        {
            throw new Exception\JSON('invalid json callback!');
        }

        return $this->json[$name];
    }

    /**
     *      Get status code
     *
     *      @return String
     */
    public function status()
    {
        return $this->status;
    }

    /**
     *      Get id
     *
     *      @return String
     */
    public function id()
    {
        return $this->id;
    }

    /**
     *      Get order id
     *
     *      @return String
     */
    public function orderId()
    {
        return $this->orderId;
    }

    /**
     *      Get number of paymnet
     *
     *      @return Int
     */
    public function number()
    {
        return $this->number;
    }

    /**
     *      Get amount
     *
     *      @return Int
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     *      Get createdAt
     *
     *      @return String
     */
    public function createdAt()
    {
        return $this->createdAt;
    }

    /**
     *      Get jsons array
     *
     *      @return Array
     */
    public function json()
    {
        return $this->json;
    }
}
