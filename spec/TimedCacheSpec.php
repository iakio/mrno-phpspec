<?php

namespace spec;

use Loader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TimedCacheSpec extends ObjectBehavior
{
    function let(Loader $loader)
    {
        $this->beConstructedWith($loader);
        $this->shouldHaveType('TimedCache');
    }

    function it_loads_object_that_is_not_cached(Loader $loader)
    {
        $key = "key"; $value = "value";
        $loader->load($key)->shouldBeCalled()->willReturn($value);
        $this->lookup($key)->shouldReturn($value);
    }
}
