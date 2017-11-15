<?php

namespace UAPAY;

use UAPAY\Log as Log;
use UAPAY\Exception;
use Firebase\JWT\JWT;

abstract class Request
{
    /**
     *      @var Object
     */
    protected $client;

    /**
     *      @var Array
     */
    protected $jwt=array(
        'using'         => false,
        'UAPAY_pubkey'  => '',
        'our_privkey'   => '',
    );

    /**
     *      @var Array
     */
    protected $data;

    /**
     *      Constructor
     *
     *      @param array $options array of options
     */
    public function __construct($options)
    {
        // api_url
        if ( ! isset($options['api_uri']))
        {
            throw new Exception\Data('parameter api_uri is not specified');
        }

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

        // http client
        $this->client = new \GuzzleHttp\Client([
            'base_uri'      => $options['api_uri'],
            'timeout'       => 2.0,
        ]);
    }

    /**
     *      get/set data
     *
     *      @param array $value
     *      @return array
     */
    public function data($value=null)
    {
        if ($value !== null)
        {
            $this->data = $this->as_array($value);
        }

        return $this->data;
    }

    /**
     *      Cast to string
     *
     *      @param mixed $value
     *      @return string
     */
    protected function as_string($value=null)
    {
        return (is_scalar($value))?((is_bool($value))?(($value)?'true':'false'):"$value"):null;
    }

    /**
     *      Cast to integer
     *
     *      @param mixed $value
     *      @return integer
     */
    protected function as_int($value=null)
    {
        return (is_int($value))?$value:null;
    }

    /**
     *      Cast to array
     *
     *      @param mixed $value
     *      @return array
     */
    protected function as_array($value=null)
    {
        return (is_array($value))?$value:null;
    }

    /**
     *      Returns params set
     *
     *      @return array
     */
    public function get_params()
    {
        return array();
    }

    /**
     *      Returns iat param
     *
     *      @return array
     */
    public function get_param_iat()
    {
        return time();
    }

    /**
     *      Returns the JSON representation of class
     *
     *      @return string
     */
    public function get_json()
    {
        $ar = array(
            'params' => $this->get_params()
        );
        if (isset($this->data))
        {
            $ar['data'] = $this->data;
        }
        if ($this->jwt['using'] === true)
        {
            $payload = $ar;
            $payload['iat'] = $this->get_param_iat();

            // check private key file
            if ( ! file_exists($this->jwt['our_privkey']))
            {
                throw new Exception\Runtime('The file with the private key was not find!');
            }

            // load private key file
            $fpkey = fopen($this->jwt['our_privkey'], "rb");
            if ($fpkey === FALSE)
            {
                throw new Exception\Runtime('The file with the private key was not open!');
            }
            $privateKey = fread($fpkey, 8192);
            if ($privateKey === FALSE)
            {
                throw new Exception\Runtime('The file with the private key was not read!');
            }
            fclose($fpkey);

            try
            {
                $token = JWT::encode($payload, $privateKey, 'RS512');
            }
            catch (\Exception $e)
            {
                Log::instance()->error($e->getMessage().PHP_EOL.$e->getTraceAsString());
                throw new Exception\JSON('unable to create JWT token', $e);
            }

            if (isset($ar['data'])) unset($ar['data']);

            $ar['token'] = $token;
        }
        $json = json_encode($ar, JSON_UNESCAPED_SLASHES);

        Log::instance()->debug('build JSON:');
        Log::instance()->debug($json);

        return $json;
    }

    public function send()
    {
        Log::instance()->debug('send request to '.$this->api_path);
        try
        {
            $httpresponse = $this->client->request('POST', $this->api_path, [
                'headers' => [
                    'User-Agent'    => 'php_UAPAY/1.0',
                    'Content-Type'  => 'application/json'
                ],
                'body' => $this->get_json()
            ]);
            $body = $httpresponse->getBody()->getContents();
            Log::instance()->debug('got response:'.PHP_EOL.$body);
            $response = new $this->response_class($body);
        }
        catch (\GuzzleHttp\Exception\TransferException $e)
        {
            Log::instance()->debug('request:'.PHP_EOL.\GuzzleHttp\Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::instance()->debug('response:'.PHP_EOL.\GuzzleHttp\Psr7\str($e->getResponse()));
            }

            throw new Exception\Transfer('an error occured during a transfer');
        }

        return $response;
    }
}
