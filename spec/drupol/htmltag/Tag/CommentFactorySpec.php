<?php

namespace spec\drupol\htmltag\Tag;

use drupol\htmltag\Tag\Comment;
use drupol\htmltag\Tag\CommentFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CommentFactory::class);
    }

    public function it_can_create_comment()
    {
        $this
            ->beConstructedThrough('build', ['comment']);
    }
}
