<?php

namespace Rpl\Framework\Middleware;

use Rpl\Framework\Serializer\SerializableInterface;
use Rpl\Framework\Serializer\SerializerInterface;

interface ReturnObjectInterface
{
    public function setSerializer(SerializerInterface $serializer): void;

    public function getSerializer(): SerializerInterface;

    public function setObject(SerializableInterface $returnObject);

    public function getObject(): SerializableInterface;
}