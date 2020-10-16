<?php

declare(strict_types=1);

namespace spec\drupol\htmltag\Tag;

use drupol\htmltag\Tag\TagFactory;
use PhpSpec\ObjectBehavior;

class TagFactorySpec extends ObjectBehavior
{
    public function it_can_build_a_tag()
    {
        $this->beConstructedThrough('build', ['p']);
        $this->render()->shouldReturn('<p/>');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(TagFactory::class);
    }
}
