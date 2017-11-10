<?php

namespace UAPAY\Sessions\Create;

use UAPAY\Log as Log;
use UAPAY\Exception;

class Response extends \UAPAY\Response
{
    /**
     *      @var String
     */
    protected $id;

    /**
     *      Constructor
     *
     *      @param array $json_string array of options
     */
    public function __construct($json_string)
    {
        parent::__construct($json_string);

        if (!isset($this->json['data']['id']))
        {
            throw new Exception\JSON('data does not contain the id field!');
        }

        $this->id = $this->json['data']['id'];
    }

    /**
     *      Get session id
     *
     *      @return string id session
     */
    public function id()
    {
            return $this->id;
    }
}
