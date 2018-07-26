<?php

namespace Rpl\Framework\Middleware;

class RequestAttributeSet
{
    private $attributes = [];

    public function set($key, $val)
    {
        $this->attributes[$key] = $val;
    }

    public function get($key)
    {
        return $this->attributes[$key];
    }

    public function has($key)
    {
        return array_key_exists($key, $this->attributes);
    }
}