<?php

namespace Rpl\Framework\Exception;

class NonSerializableException extends \Exception
{
    /**
     * NonSerializableException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}