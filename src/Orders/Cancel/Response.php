<?php

namespace UAPAY\Orders\Cancel;

use UAPAY\Log as Log;
use UAPAY\Exception;

class Response extends \UAPAY\Response
{
    /**
     *      @var string
     */
    protected $id;

    /**
     *      @var array
     */
    protected $data;

    /**
     *      Handle decoded JSON
     *
     *      @throws Exception\JSON
     */
    public function json_handle()
    {
        parent::json_handle();

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
