<?php

namespace spec\drupol\htmltag\tests;

use drupol\htmltag\tests\TestTagFactory;
use PhpSpec\ObjectBehavior;

class TestTagFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TestTagFactory::class);
    }

    public function it_can_detect_if_a_class_is_invalid()
    {
        $this->shouldThrow(\Exception::class)->during('build', ['p']);
    }
}
