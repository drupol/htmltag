<?php

namespace spec\drupol\htmltag;

use drupol\htmltag\Tag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
      $this->beConstructedWith('tag');
      $this->shouldHaveType(Tag::class);
    }

    function it_should_create_a_tag() {
      $this->beConstructedWith('p');
      $this
        ->attr('class')
        ->append('paragraph');
      $this->__toString()
        ->shouldBe('<p class="paragraph"/>');

      $subtag = new Tag('b');
      $subtag->content(['bold text']);

      $this->content(['hello ', $subtag]);
      $this
        ->__toString()
        ->shouldBe('<p class="paragraph">hello <b>bold text</b></p>');
    }
}
