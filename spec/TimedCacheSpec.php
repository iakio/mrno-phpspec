<?php

namespace spec;

use Loader;
use Clock;
use ReloadPolicy;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TimedCacheSpec extends ObjectBehavior
{
    function let(Loader $loader, Clock $clock, ReloadPolicy $reloadPolicy)
    {
        $this->beConstructedWith($loader, $clock, $reloadPolicy);
        $this->shouldHaveType('TimedCache');
    }

    function it_returns_cached_object_within_timeout(Loader $loader, Clock $clock, ReloadPolicy $reloadPolicy)
    {
        $key = "key"; $value = "value";
        $loadTime = new \DateTime("2014-01-01");
        $fetchTime = new \DateTime("2014-02-01");

        $clock->getCurrentTime()
            ->willThrow(new \Exception("Clock#getCurrentTime() was called before Loader#load()"));

        $reloadPolicy->shouldReload($loadTime, $fetchTime)
            ->shouldBeCalled()
            ->willReturn(false);

        $loader->load($key)
            ->shouldBeCalledTimes(1)
            ->will(function () use ($value, $clock, $loadTime, $fetchTime) {
                $clock->getCurrentTime()
                    ->shouldBeCalledTimes(1)
                    ->will(function () use ($loadTime, $fetchTime) {
                        $this->getCurrentTime()
                            ->shouldBeCalled(1)
                            ->willReturn($fetchTime);

                        return $loadTime;
                    });
                return $value;
            });

        $this->lookup($key)->shouldReturn($value);
        $this->lookup($key)->shouldReturn($value);
    }
}
