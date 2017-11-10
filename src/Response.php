<?php

namespace UAPAY;

use UAPAY\Log as Log;
use UAPAY\Exception;

abstract class Response
{
    /**
     *      @var String
     */
    protected $json;

    /**
     *      @var int
     */
    protected $status;

    /**
     *      Constructor
     *
     *      @param array $json_string array of options
     */
    public function __construct($json_string)
    {
        $this->json = json_decode($json_string, true);
        if (json_last_error() != 0)
        {
            throw new Exception\Runtime('decoding error of the json response!');
        }

        if (isset($this->json['error']))
        {
            throw new Exception\JSON('json response contain an error message!');
        }
        if (!isset($this->json['status']))
        {
            throw new Exception\JSON('invalid json response!');
        }
        if ($this->json['status'] == 0)
        {
            throw new Exception\JSON('json response contain an error status!');
        }
        $this->status = $this->json['status'];

        if (!isset($this->json['data']) || !is_array($this->json['data']))
        {
            throw new Exception\JSON('json does not contain the data field!');
        }
    }

    /**
     *      Get status code
     *
     *      @return int
     */
    public function status()
    {
        return $this->status;
    }
}
