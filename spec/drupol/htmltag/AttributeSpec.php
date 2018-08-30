<?php

namespace spec\drupol\htmltag;

use drupol\htmltag\Attribute;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributeSpec extends ObjectBehavior
{
  function it_is_initializable()
  {
    $this->beConstructedWith('name', 'value');
    $this->shouldHaveType(Attribute::class);
  }

  function it_can_trim_its_name_when_constructing() {
    $this->beConstructedWith('name ', 'value1 value2');
    $this->getName()->shouldBe('name');
    $this->getValueAsString()->shouldBe('value1 value2');
    $this->getValueAsArray()->shouldBe(['value1', 'value2']);
    $this->__toString()->shouldBe('name="value1 value2"');
  }

  function it_can_replace_values() {
    $this->beConstructedWith('name ', 'c b a');
    $this->replace('a', 'A');
    $this->getValueAsString()->shouldBe('c b A');
    $this->getValueAsArray()->shouldBe(['c', 'b', 'A']);
    $this->__toString()->shouldBe('name="c b A"');
    $this->replace('a', 'Z');
    $this->getValueAsString()->shouldBe('c b A');
    $this->getValueAsArray()->shouldBe(['c', 'b', 'A']);
    $this->__toString()->shouldBe('name="c b A"');
  }

  function it_can_remove_values() {
    $this->beConstructedWith('name ', 'c b a');
    $this->remove('a');
    $this->getValueAsString()->shouldBe('c b');
    $this->getValueAsArray()->shouldBe(['c', 'b']);
    $this->__toString()->shouldBe('name="c b"');
    $this->remove('A');
    $this->getValueAsString()->shouldBe('c b');
    $this->getValueAsArray()->shouldBe(['c', 'b']);
    $this->__toString()->shouldBe('name="c b"');
  }

  function it_can_append() {
    $this->beConstructedWith('name ');
    $this->append('a');
    $this->getValueAsString()->shouldBe('a');
    $this->__toString()->shouldBe('name="a"');
    $this->append('b');
    $this->getValueAsString()->shouldBe('a b');
    $this->__toString()->shouldBe('name="a b"');
  }
}
