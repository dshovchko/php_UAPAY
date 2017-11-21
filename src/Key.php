<?php

namespace UAPAY;

use UAPAY\Exception;

class Key
{
    public function __construct() {}

    /**
     *      Get content of key file
     *      @param string $fname
     *      @param string $type
     *      @return string
     *      @throws Exception\Runtime
     */
    public function get($fname, $type)
    {
        try
        {
            $this->check_exists($fname);

            $key = $this->load($fname);
        }
        catch (\Exception $e)
        {
            throw new Exception\Runtime('The file with the '.$type.' key was '.$e->getMessage().'!');
        }

        return $key;
    }

    /**
     *      Check if exist key file
     *
     *      @param string $fname
     *      @throws Exception\Runtime
     */
    protected function check_exists($fname)
    {
        if ( ! file_exists($fname))
        {
            throw new Exception\Runtime('not exists');
        }
    }

    /**
     *      Load key file
     *
     *      @param string $fname
     *      @return string
     *      @throws Exception\Runtime
     */
    protected function load($fname)
    {
        $key = @file_get_contents($fname);
        if ($key === FALSE)
        {
            throw new Exception\Runtime('not read');
        }

        return $key;
    }
}
