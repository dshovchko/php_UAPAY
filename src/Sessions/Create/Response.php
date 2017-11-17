<?php

namespace UAPAY\Sessions\Create;

use UAPAY\Log as Log;
use UAPAY\Exception;

class Response extends \UAPAY\Response
{
    /**
     *      @var string
     */
    protected $id;

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
