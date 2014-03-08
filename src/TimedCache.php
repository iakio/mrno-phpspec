<?php

class TimedCache
{
    protected $loader;
    protected $cache = [];

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function lookup($key)
    {
        if (array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        }
        $value = $this->loader->load($key);
        $this->cache[$key] = $value;
        return $value;
    }
}
