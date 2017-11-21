<?php

namespace UAPAY;

use UAPAY\Log as Log;
use UAPAY\Exception;
use Firebase\JWT\JWT;

abstract class Response
{
    /**
     *      @var array
     */
    protected $json;

    /**
     *      @var array
     */
    protected $jwt=array(
        'using'         => false,
        'UAPAY_pubkey'  => '',
        'our_privkey'   => '',
    );

    /**
     *      @var int
     */
    protected $status;

    /**
     *      Constructor
     *
     *      @param string $json_string JSON string
     *      @param array $jwt_options array of options
     */
    public function __construct($json_string, $jwt_options=null)
    {
        if (isset($jwt_options) && is_array($jwt_options))
        {
            $this->jwt = array_merge($this->jwt, $jwt_options);
        }

        $this->json = $this->json_decode($json_string);
        $this->json_handle();
    }

    /**
     *      Decode JSON
     *
     *      @param string $json_string
     *      @return array
     *      @throws Exception\Runtime
     */
    protected function json_decode($json_string)
    {
        $decoded = json_decode($json_string, true);

        if (json_last_error() != 0)
        {
            throw new Exception\Runtime('decoding error of the json response!');
        }

        return $decoded;
    }

    /**
     *      Handle decoded JSON
     *
     *      @throws Exception\JSON
     */
    protected function json_handle()
    {
        if (isset($this->json['error']))
        {
            throw new Exception\JSON('json response contain an error message!');
        }
        if ( ! isset($this->json['status']))
        {
            throw new Exception\JSON('invalid json response!');
        }
        if ($this->json['status'] == 0)
        {
            throw new Exception\JSON('json response contain an error status!');
        }
        $this->status = $this->json['status'];

        if ( ! isset($this->json['data']) || !is_array($this->json['data']))
        {
            throw new Exception\JSON('json does not contain the data field!');
        }

        if ($this->jwt['using'] === true)
        {
            if ( ! isset($this->json['data']['token']))
            {
                throw new Exception\JSON('data does not contain the token field!');
            }

            $this->json['data'] = $this->token_decode($this->json['data']['token']);
        }
    }

    /**
     *      Get UAPAY public key
     *
     *      @return string Public key
     */
    protected function uapay_public_key()
    {
        return (new Key())->get($this->jwt['UAPAY_pubkey'], 'public');
    }

    /**
     *      Decode token
     *
     *      @param string $token
     *      @throws Exception\Runtime
     *      @return array
     */
    protected function token_decode($token)
    {
        try
        {
            $decoded = (array) JWT::decode($token, $this->uapay_public_key(), array('RS512'));
        }
        catch (\Exception $e)
        {
            Log::instance()->error($e->getMessage().PHP_EOL.$e->getTraceAsString());
            throw new Exception\JSON('unable to decode JWT token', $e);
        }

        Log::instance()->debug('decoded payload:');
        Log::instance()->debug(print_r($decoded, true));

        return $decoded;
    }

    /**
     *      Get status code
     *
     *      @return int
     */
    public function status()
    {
        return $this->status;
    }
}
