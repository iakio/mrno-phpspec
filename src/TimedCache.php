<?php

class TimedCache
{
    protected $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function lookup($key)
    {
        return $this->loader->load($key);
    }
}
