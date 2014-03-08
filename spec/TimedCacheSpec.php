<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TimedCacheSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TimedCache');
    }
}
