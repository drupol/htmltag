<?php

declare(strict_types=1);

namespace spec\drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Tag\Comment;
use PhpSpec\ObjectBehavior;

class CommentSpec extends ObjectBehavior
{
    public function it_can_create_a_comment()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, [], 'Hello world');
        $this
            ->render()
            ->shouldReturn('<!--Hello world-->');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Comment::class);
    }

    public function let()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, [], '!--');
    }
}
