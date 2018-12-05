<?php

namespace spec\drupol\htmltag\tests;

use drupol\htmltag\tests\TestAttributeFactory;
use PhpSpec\ObjectBehavior;

class TestAttributeFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TestAttributeFactory::class);
    }

    public function it_can_detect_if_a_class_is_invalid()
    {
        $this->shouldThrow(\Exception::class)->during('build', ['src']);
    }

    public function it_can_detect_if_a_class_is_valid()
    {
        $this->beConstructedThrough('build', ['class', 'class']);
        $this->render()->shouldReturn('class="class"');
    }
}
