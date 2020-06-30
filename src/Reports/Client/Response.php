<?php

namespace UAPAY\Reports\Client;

use UAPAY\Log as Log;
use UAPAY\Exception;

class Response extends \UAPAY\Response
{
    /**
     *      @var string
     */
    protected $id;

    /**
     *      @var string
     */
    protected $paymentPageUrl;

    /**
     *      Handle decoded JSON
     *
     *      @throws Exception\JSON
     */
    protected function json_handle()
    {
        parent::json_handle();

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
