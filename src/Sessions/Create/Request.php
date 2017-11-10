<?php

namespace UAPAY\Sessions\Create;

use UAPAY\Log as Log;

class Request extends \UAPAY\Request
{
    /**
     *      @var String
     */
    protected $clientId;

    /**
     *      @var String
     */
    protected $api_path = '/api/sessions/create';

    /**
     *      @var String
     */
    protected $response_class = '\UAPAY\Sessions\Create\Response';

    /**
     *      Constructor
     *
     *      @param array $options array of options
     */
    public function __construct($options)
    {
        parent::__construct($options);

        if (isset($options['clientId']))
        {
            $this->clientId($options['clientId']);
        }
    }

    /**
     *      get/set clientId
     *
     *      @param string $value
     *      @return string
     */
    public function clientId($value=null)
    {
        if ($value !== null)
        {
            $this->clientId = $this->as_string($value);
        }

        return $this->clientId;
    }

    /**
     *      Returns params set
     *
     *      @return array
     */
    public function get_params()
    {
        return array(
            'clientId' => $this->clientId,
        );
    }
}
