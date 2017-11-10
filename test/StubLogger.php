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

class StubLogger extends Debulog\Logger
{
    /**
     *      Add message to logger buffer
     *
     *      @param string $message Message text
     *
     */
    public function add($message){}

    /**
     *      Add error message to logger buffer
     *
     *      @param string $message Message text
     *
     */
    public function error($message){}

    /**
     *      Add debug message to logger buffer
     *
     *      @param string $message Message to log
     *
     */
    public function debug($message){}

    /**
     *      Sync all buffers to files
     *
     */
    public function sync(){}
}
