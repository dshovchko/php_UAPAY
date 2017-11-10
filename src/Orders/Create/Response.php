<?php

namespace UAPAY\Orders\Create;

use UAPAY\Log as Log;
use UAPAY\Exception;

class Response extends \UAPAY\Response
{
    /**
     *      @var String
     */
    protected $id;

    /**
     *      @var String
     */
    protected $paymentPageUrl;
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

        if (!isset($this->json['data']['paymentPageUrl']))
        {
            throw new Exception\JSON('data does not contain the paymentPageUrl field!');
        }

        $this->paymentPageUrl = $this->json['data']['paymentPageUrl'];
    }

    /**
     *      Get order id
     *
     *      @return string id order
     */
    public function id()
    {
        return $this->id;
    }

    /**
     *      Get paymentPageUrl to go to the payment page
     *
     *      @return string paymentPageUrl
     */
    public function paymentPageUrl()
    {
        return $this->paymentPageUrl;
    }
}
