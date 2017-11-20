<?php

namespace UAPAY;

use UAPAY\Log as Log;
use UAPAY\Exception;

class Callback extends Response
{
    /**
     *      @var string
     */
    protected $id;

    /**
     *      @var string
     */
    protected $orderId;

    /**
     *      @var int
     */
    protected $number;

    /**
     *      @var int
     */
    protected $amount;

    /**
     *      @var string
     */
    protected $createdAt;

    /**
     *      Constructor
     *
     *      @param array $jwt_options array of options
     */
    public function __construct($options=null)
    {
        $jo = new JWTOptions($options);
        parent::__construct($this->get_http_raw_post_data(), $jo->get());
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
     *      Handle decoded JSON
     *
     *      @throws Exception\JSON
     */
    protected function json_handle()
    {
        if (isset($this->json['error']))
        {
            throw new Exception\JSON('json callback contain an error message!');
        }

        if ($this->jwt['using'] === true)
        {
            if ( ! isset($this->json['token']))
            {
                throw new Exception\JSON('json does not contain the token field!');
            }

            $this->json = $this->token_decode($this->json['token']);
        }

        $this->status = $this->json_value('status');
        $this->id = $this->json_value('id');
        $this->orderId = $this->json_value('orderId');
        $this->number = $this->json_value('number');
        $this->amount = $this->json_value('amount');
        $this->createdAt = $this->json_value('createdAt');
    }

    /**
     *      Get value from JSON
     *
     *      @param string $name
     *      @return mixed
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
     *      Get id
     *
     *      @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     *      Get order id
     *
     *      @return string
     */
    public function orderId()
    {
        return $this->orderId;
    }

    /**
     *      Get number of paymnet
     *
     *      @return int
     */
    public function number()
    {
        return $this->number;
    }

    /**
     *      Get amount
     *
     *      @return int
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     *      Get createdAt
     *
     *      @return string
     */
    public function createdAt()
    {
        return $this->createdAt;
    }

    /**
     *      Get jsons array
     *
     *      @return array
     */
    public function json()
    {
        return $this->json;
    }
}
