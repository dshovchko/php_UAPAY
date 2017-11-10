<?php

namespace UAPAY\Orders\Cancel;

use UAPAY\Log as Log;
use UAPAY\Exception;

class Response extends \UAPAY\Response
{
    /**
     *      @var String
     */
    protected $id;

    /**
     *      @var Array
     */
    protected $data;
    /**
     *      Constructor
     *
     *      @param array $json_string array of options
     */
    public function __construct($json_string)
    {
        parent::__construct($json_string);

        $this->data = $this->json['data'];
    }

    /**
     *      Get info about order
     *
     *      @return array data
     */
    public function data()
    {
        return $this->data;
    }
}
