<?php

declare(strict_types=1);

namespace spec\drupol\htmltag\tests;

use drupol\htmltag\tests\TestTagFactory;
use Exception;
use PhpSpec\ObjectBehavior;

class TestTagFactorySpec extends ObjectBehavior
{
    public function it_can_detect_if_a_class_is_invalid()
    {
        $this->shouldThrow(Exception::class)->during('build', ['p']);
    }

    public function it_can_detect_if_a_class_is_valid()
    {
        $this->beConstructedThrough('build', ['a']);
        $this->content('content')->shouldReturn('content');
        $this->render()->shouldReturn('<a>content</a>');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TestTagFactory::class);
    }
}
