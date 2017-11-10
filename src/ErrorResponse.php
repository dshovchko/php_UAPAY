<?php

namespace UAPAY;

use UAPAY\Log as Log;
use UAPAY\Exception\RuntimeException;
use UAPAY\Exception\FormatException;
use UAPAY\Exception\StatusException;


class ErrorResponse extends Response
{
    /**
     *      @var String
     */
    protected $error_code;

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
            throw new RuntimeException('decoding error of the json response!');
        }

        if (!isset($this->json['status']))
        {
            throw new FormatException('invalid json response!');
        }
        if ($this->json['status'] == 1)
        {
            throw new StatusException('json does not contain an error!');
        }
        $this->status = $this->json['status'];

        if (!isset($this->json['error']) || !is_array($this->json['error']))
        {
            throw new FormatException('invalid json response!');
        }
        $this->error_code = (isset($this->json['error']['code']))?$this->json['error']['code']:'undefined';
    }

    /**
     *      Get error code
     *
     *      @return string
     */
    public function error_code()
    {
        return $this->error_code;
    }
}
