<?php

/**
 *      Class for logging
 *
 *      @package php_UAPAY
 *      @version 1.0
 *      @author Dmitry Shovchko <d.shovchko@gmail.com>
 */

namespace UAPAYTest;

use Debulog;

class MockLogger extends Debulog\Logger
{
    /**
     *      @var array
     */
    protected $_add;

    /**
     *      @var array
     */
    protected $_error;

    /**
     *      @var array
     */
    protected $_debug;

    /**
     *      Logger constructor
     *
     */
    public function __construct(){}

    /**
     *      Add message to logger buffer
     *
     *      @param string $message Message text
     *
     */
    public function add($message)
    {
        $this->_add[] = $message;
    }

    /**
     *      Show data in log
     *
     *      @return array
     */
    public function show_log()
    {
        return $this->_add;
    }

    /**
     *      Add error message to logger buffer
     *
     *      @param string $message Message text
     *
     */
    public function error($message)
    {
        $this->_error[] = $message;
    }

    /**
     *      Show data in error_log
     *
     *      @return array
     */
    public function show_error_log()
    {
        return $this->_error;
    }

    /**
     *      Add debug message to logger buffer
     *
     *      @param string $message Message to log
     *
     */
    public function debug($message)
    {
        $this->_debug[] = $message;
    }

    /**
     *      Show data in debug_log
     *
     *      @return array
     */
    public function show_debug_log()
    {
        return $this->_debug;
    }

    /**
     *      Sync all buffers to files
     *
     */
    public function sync()
    {
        $this->_add[] = array();
        $this->_error[] = array();
        $this->_debug[] = array();
    }
}
