<?php
namespace UAPAY\Exception;

use UAPAY\Log as Log;

class General extends \RuntimeException implements EInterface
{
    /**
     *      Constructor
     *
     *      @param string $message
     *      @param \Throwable $previous
     */
    public function __construct($message, \Exception $previous=null, $tracelog=false)
    {
        Log::instance()->error($message.(($tracelog)?PHP_EOL.$this->getTraceAsString():null));
        $code = 0;
        parent::__construct($message, $code, $previous);
    }
}
