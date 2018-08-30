<?php

namespace spec\drupol\htmltag;

use drupol\htmltag\Attributes;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributesSpec extends ObjectBehavior
{
  function it_is_initializable()
  {
    $this->shouldHaveType(Attributes::class);
  }

  function it_should_append_attribute_and_value() {
    $this
      ->append('class', 'plop')
      ->__toString()
      ->shouldBe(' class="plop"');
  }

  function it_should_append_loner_attribute() {
    $this
      ->append('data-closable')
      ->__toString()
      ->shouldBe(' data-closable');
  }

  function it_can_append_and_remove() {
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
