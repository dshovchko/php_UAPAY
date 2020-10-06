<?php

namespace UAPAY;

use UAPAY\Exception;

class JWTOptions
{
    /**
     *      @var array
     */
    protected $jwt = array(
        'using'         => false,
        'UAPAY_pubkey'  => '',
        'our_privkey'   => '',
        'key_type'      => '',
        'algorithm'     => '',
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
            $this->is_valid_using($options);
            $this->is_present_option($options, 'UAPAY_pubkey');
            $this->is_present_option($options, 'our_privkey');
            $this->is_present_option($options, 'algorithm');

            $this->jwt = $options['jwt'];
        }
    }

    /**
     *      Check is valid 'using' option
     *
     *      @param array $options
     *      @throws Exception\Data
     */
    protected function is_valid_using($options)
    {
        $this->is_present_option($options, 'using');
        if ( ! is_bool($options['jwt']['using']))
        {
            throw new Exception\Data('parameter jwt/using is incorrect');
        }
    }

    /**
     *      Check is present option
     *
     *      @param array $options
     *      @param string $name
     *      @throws Exception\Data
     */
    protected function is_present_option($options, $name)
    {
        if ( ! isset($options['jwt'][$name]))
        {
            throw new Exception\Data('parameter jwt/'.$name.' is not specified');
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
