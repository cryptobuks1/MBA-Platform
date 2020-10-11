<?php
class RNGException extends Exception
{
    function __construct($message = "", $code = 0, $exception = null)
    {
    	parent::__construct($message, $code, $exception);
    }
}