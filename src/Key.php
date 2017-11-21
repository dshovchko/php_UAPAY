<?php

namespace UAPAY;

use UAPAY\Exception;

class Key
{
    public function __construct() {}

    /**
     *      Get content of key file
     *      @param string $fname
     *      @return string
     */
    public function get($fname)
    {
        $this->check_exists($fname);

        return $this->load($fname);
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
