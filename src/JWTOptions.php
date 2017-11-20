<?php

namespace UAPAY;

use UAPAY\Log as Log;
use UAPAY\Exception;

class JWTOptions
{
    /**
     *      @var array
     */
    protected $jwt=array(
        'using'         => false,
        'UAPAY_pubkey'  => '',
        'our_privkey'   => '',
    );

    /**
     *      Constructor
     *
     *      @param array $options array of options
     *      @throws Exception\Data
     */
    public function __construct($options)
    {
        if (isset($options['jwt']))
        {
            // using
            if ( ! isset($options['jwt']['using']))
            {
                throw new Exception\Data('parameter jwt/using is not specified');
            }
            if ( ! is_bool($options['jwt']['using']))
            {
                throw new Exception\Data('parameter jwt/using is incorrect');
            }
            // using
            if ( ! isset($options['jwt']['UAPAY_pubkey']))
            {
                throw new Exception\Data('parameter jwt/UAPAY_pubkey is not specified');
            }
            // using
            if ( ! isset($options['jwt']['our_privkey']))
            {
                throw new Exception\Data('parameter jwt/our_privkey is not specified');
            }

            $this->jwt = $options['jwt'];
        }
    }

    /**
     *      Get jwt options
     *
     *      @return array
     */
    public function get()
    {
        return $this->jwt;
    }
}
