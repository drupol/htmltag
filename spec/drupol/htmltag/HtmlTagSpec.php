<?php

namespace spec\drupol\htmltag;

use drupol\htmltag\Attributes\AttributesInterface;
use drupol\htmltag\Attribute\AttributeInterface;
use drupol\htmltag\Tag\TagInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HtmlTagSpec extends ObjectBehavior
{
    public function it_can_build_a_tag()
    {
        $this::tag(
            'region',
            ['class' => 'sidebar'],
            ['hello region']
        )
            ->shouldBeAnInstanceOf(TagInterface::class);

        $this::tag(
            'region',
            ['class' => 'sidebar'],
            ['hello region']
        )
            ->render()
            ->shouldReturn('<region class="sidebar">hello region</region>');
    }

    public function it_can_build_attributes()
    {
        $this::attributes(
            [
                'foo' => 'bar',
                'class' => 'sidebar'
            ]
        )
            ->shouldBeAnInstanceOf(AttributesInterface::class);

        $this::attributes(
            [
                'foo' => 'bar',
                'class' => 'sidebar',
            ]
        )
            ->render()
            ->shouldReturn(' foo="bar" class="sidebar"');
    }

    public function it_can_build_attribute()
    {
        $this::attribute('foo', 'bar')
            ->shouldBeAnInstanceOf(AttributeInterface::class);

        $this::attribute('foo', 'bar')
            ->render()
            ->shouldReturn('foo="bar"');
    }
}
