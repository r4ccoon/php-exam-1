<?php

namespace Rpl\Framework\Serializer;

trait SerializableTrait
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    public function serialize(SerializableInterface $object): string
    {
        return $this->serializer->serialize($object);
    }
}
