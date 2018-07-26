<?php

namespace Rpl\Framework\Serializer;

interface SerializerInterface
{
    public function serialize(SerializableInterface $object): string;
}
