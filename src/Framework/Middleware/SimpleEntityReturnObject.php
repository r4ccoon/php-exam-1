<?php

namespace Rpl\Framework\Middleware;

use Rpl\Framework\Serializer\SerializableInterface;
use Rpl\Framework\Serializer\SerializableTrait;

class SimpleEntityReturnObject implements ReturnObjectInterface
{
    use SerializableTrait;

    /**
     * @var SerializableInterface
     */
    protected $returnObject;


    public function setObject(SerializableInterface $returnObject)
    {
        $this->returnObject = $returnObject;
    }

    public function getObject(): SerializableInterface
    {
        return $this->returnObject;
    }
}