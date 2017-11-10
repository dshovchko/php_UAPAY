<?php
namespace UAPAY\Exception;

use UAPAY\Log as Log;

class Runtime extends General implements EInterface
{
    /**
     *      Constructor
     *
     *      @param string $message
     *      @param Throwable $previous
     */
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, $previous, true);
    }
}
