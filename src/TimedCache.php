<?php

class TimedCache
{
    protected $loader;
    protected $clock;
    protected $reloadPolicy;
    protected $cache = [];

    public function __construct(Loader $loader, Clock $clock, ReloadPolicy $reloadPolicy)
    {
        $this->loader = $loader;
        $this->clock = $clock;
        $this->reloadPolicy = $reloadPolicy;
    }

    protected function getCachedValue($key)
    {
        if (array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        }
        return null;
    }


    protected function loadObject($key)
    {
        $value = $this->loader->load($key);
        $timeStampedValue = new TimeStampedValue();
        $timeStampedValue->loadTime = $this->clock->getCurrentTime();
        $timeStampedValue->value = $value;
        $this->cache[$key] = $timeStampedValue;
        return $timeStampedValue;
    }

    public function lookup($key)
    {
        $found = $this->getCachedValue($key);
        if ($found === null || $this->reloadPolicy->shouldReload($found->loadTime, $this->clock->getCurrentTime())) {
            $found = $this->loadObject($key);
        }
        return $found->value;
    }
}
