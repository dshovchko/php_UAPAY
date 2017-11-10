<?php

/**
 *      Class for logging
 *
 *      @package php_UAPAY
 *      @version 1.0
 *      @author Dmitry Shovchko <d.shovchko@gmail.com>
 *
 */

namespace UAPAY;

use Debulog;

class Log {

    /**
     *      @var Log
     */
    protected static $_instance;

    /**
     *      gets the instance
     *
     *      @return Log
     */
    public static function instance()
    {
        return self::$_instance;
    }

    /**
     *      sets the logger instance
     *
     *      @param Debulog\LoggerInterface $log
     */
    public static function set(Debulog\LoggerInterface $log)
    {
        self::$_instance = $log;
    }
}
