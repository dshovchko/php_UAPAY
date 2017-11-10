<?php

namespace UAPAY\Reports\Client;

use UAPAY\Log as Log;

class Request extends \UAPAY\Request
{
    /**
     *      @var String
     */
    protected $sessionId;

    /**
     *      @var String
     */
    protected $api_path = '/api/reports/client';

    /**
     *      @var String
     */
    protected $response_class = '\UAPAY\Reports\Client\Response';

    /**
     *      Constructor
     *
     *      @param array $options array of options
     */
    public function __construct(Array $options)
    {
        parent::__construct($options);
    }

    /**
     *      get/set sessionId
     *
     *      @param string $value
     *      @return string
     */
    public function sessionId($value=null)
    {
        if ($value !== null)
        {
            $this->sessionId = $this->as_string($value);
        }

        return $this->sessionId;
    }

    /**
     *      Returns params set
     *
     *      @return array
     */
    public function get_params()
    {
        return array(
            'sessionId' => $this->sessionId(),
        );
    }
}
