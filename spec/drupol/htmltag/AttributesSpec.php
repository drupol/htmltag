<?php

namespace spec\drupol\htmltag;

use drupol\htmltag\Attributes;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Attributes::class);
    }

    public function it_should_append_attribute_and_value()
    {
        $this
      ->append('class', 'plop')
      ->__toString()
      ->shouldBe(' class="plop"');
    }

    public function it_should_append_loner_attribute()
    {
        $this
      ->append('data-closable')
      ->__toString()
      ->shouldBe(' data-closable');
    }

    public function it_can_append_and_remove()
    {
        $this
      ->append('data-closable')
      ->append('class', 'foo')
      ->__toString()
      ->shouldBe(' class="foo" data-closable');

        $this
      ->remove('class', 'fool')
      ->__toString()
      ->shouldBe(' class="foo" data-closable');

        $this
      ->remove('class', 'foo')
      ->__toString()
      ->shouldBe(' class data-closable');

        $this
      ->delete('class')
      ->delete('data-closable')
      ->__toString()
      ->shouldBe('');
    }
}
