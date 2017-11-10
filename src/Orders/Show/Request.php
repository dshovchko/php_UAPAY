<?php

namespace UAPAY\Orders\Show;

use UAPAY\Log as Log;

class Request extends \UAPAY\Request
{
    /**
     *      @var String
     */
    protected $id;

    /**
     *      @var String
     */
    protected $api_path = '/api/orders/show';

    /**
     *      @var String
     */
    protected $response_class = '\UAPAY\Orders\Show\Response';

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
     *      get/set id
     *
     *      @param string $value
     *      @return string
     */
    public function id($value=null)
    {
        if ($value !== null)
        {
            $this->id = $this->as_string($value);
        }

        return $this->id;
    }

    /**
     *      Returns params set
     *
     *      @return array
     */
    public function get_params()
    {
        return array(
            'id' => $this->id(),
        );
    }
}
