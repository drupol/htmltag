<?php

namespace spec\drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\StringableInterface;
use drupol\htmltag\Tag\Tag;
use PhpSpec\ObjectBehavior;

class TagSpec extends ObjectBehavior
{
    public function it_can_alter_the_content()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, 'p');

        $this->render()->shouldReturn('<p/>');

        $this
            ->alter(static function (array $values) {
                return \array_map('strtoupper', $values);
            })
            ->render()
            ->shouldReturn('<p/>');

        $this->content('hello content', 'goodbye content');

        $this
            ->alter(static function (array $values) {
                return \array_map('strtoupper', $values);
            })
            ->render()
            ->shouldReturn('<p>HELLO CONTENTGOODBYE CONTENT</p>');

        $this
            ->alter(static function (array $values) {
                $values[] = '<a href="#htmltag">htmltag</a>';
                $values[] = new \stdClass();
                $values[] = [
                    'boo',
                    'foo',
                    'bar',
                    [
                        new randomPrintableObject('<a href="#htmltag">htmltag</a>'),
                    ],
                ];

                return $values;
            })
            ->render()
            ->shouldReturn('<p>HELLO CONTENTGOODBYE CONTENT&lt;a href=&quot;#htmltag&quot;&gt;htmltag&lt;/a&gt;boofoobar<a href="#htmltag">htmltag</a></p>');
    }

    public function it_can_be_constructed_statically()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, 'p');

        $p = $this->__callStatic('p', [$attributes]);

        $this->render()->shouldReturn($p->render());
    }

    public function it_can_be_serialized()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, 'p');
        $this->attr('class', 'hello class');
        $this->content('hello content');

        $this->serialize()->shouldReturn('a:3:{s:3:"tag";s:1:"p";s:10:"attributes";a:1:{s:5:"class";a:1:{i:0;s:11:"hello class";}}s:7:"content";s:13:"hello content";}');
    }

    public function it_can_be_unserialized()
    {
        $this->unserialize('a:3:{s:3:"tag";s:1:"p";s:10:"attributes";a:1:{s:5:"class";a:1:{i:0;s:11:"hello class";}}s:7:"content";s:13:"hello content";}');

        $this->render()->shouldReturn('<p class="hello class">hello content</p>');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Tag::class);
    }

    public function it_should_be_able_to_create_and_delete_the_content()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, 'p');
        $this->content(['hello', ' world']);
        $this->content()->shouldBe('hello world');
        $this->render()->shouldBe('<p>hello world</p>');

        $this->content(null);
        $this->render()->shouldBe('<p/>');
        $this->content([''])->shouldBe('');
        $this->render()->shouldBe('<p></p>');
    }

    public function it_should_create_a_tag()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, 'p');
        $this
            ->attr('class')
            ->append('paragraph');
        $this->render()
            ->shouldBe('<p class="paragraph"/>');

        $subtag = new Tag(AttributesFactory::build(), 'b');
        $subtag->content(['bold text']);

        $this->content(['hello ', $subtag, $subtag->render()]);
        $this
            ->render()
            ->shouldBe('<p class="paragraph">hello <b>bold text</b>&lt;b&gt;bold text&lt;/b&gt;</p>');
    }

    public function it_should_return_the_attributes_as_string()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, 'p');
        $this
            ->attr('class')
            ->append('paragraph');
        $this->attr()->shouldBe(' class="paragraph"');

        $this->render()
            ->shouldBe('<p class="paragraph"/>');
    }

    public function let()
    {
        $attributes = AttributesFactory::build();
        $this->beConstructedWith($attributes, 'tag');
    }
}

class randomPrintableObject implements StringableInterface
{
    /**
     * @var string
     */
    private $storage;

    /**
     * randomPrintableObject constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->storage = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->storage;
    }
}
