<?php

namespace spec\drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Tag\Comment;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('comment');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Comment::class);
    }

    public function it_can_create_a_comment()
    {
        $this->beConstructedWith('Hello world');
        $this
            ->render()
            ->shouldReturn('<!--Hello world-->');
    }
}
