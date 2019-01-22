<?php

declare(strict_types = 1);

namespace spec\drupol\htmltag\tests;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\tests\TestEscapeAttributes;
use PhpSpec\ObjectBehavior;

class TestEscapeAttributesSpec extends ObjectBehavior
{
    public function it_cannot_be_escaped()
    {
        $this->shouldThrow(\Exception::class)->during('publicEscape');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TestEscapeAttributes::class);
    }

    public function let(AttributeFactory $attributeFactory)
    {
        $attributeFactory = new AttributeFactory();

        $this->beConstructedWith($attributeFactory);
    }
}
