<?php

class InvalidTokenException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}

?>