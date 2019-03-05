<?php

namespace spec\drupol\htmltag\Attribute;

use drupol\htmltag\Attribute\Attribute;
use drupol\htmltag\StringableInterface;
use PhpSpec\ObjectBehavior;

class AttributeSpec extends ObjectBehavior
{
    public function it_can_alter_the_values()
    {
        $this->beConstructedWith('name');
        $this->append('hello world');

        $this
            ->alter(
                function ($values) {
                    return \array_map('strtoupper', $values);
                }
            )
            ->render()
            ->shouldReturn('name="HELLO WORLD"');

        $this
            ->alter(
                function (array $values) {
                    $values[] = 'foo';
                    $values[] = '0';
                    $values[] = [
                        new \stdClass(),
                    ];
                    $values[] = new randomPrintableObject('<a href="#htmltag">htmltag</a>'); // Invalid stuff injected

                    return $values;
                }
            )
            ->render()
            // Invalid stuff but it's completely normal as we injected a StringableInterface object.
            ->shouldReturn('name="HELLO WORLD foo 0 &lt;a href=&quot;#htmltag&quot;&gt;htmltag&lt;/a&gt;"');
    }

    public function it_can_append()
    {
        $this->beConstructedWith('name');
        $this
            ->append('a')
            ->shouldReturn($this);

        $this->render()->shouldBe('name="a"');
        $this->append('b');
        $this->render()->shouldBe('name="a b"');

        $this->setBoolean(true);
        $this->append(['a  d ', [' b', ['c ', [' d  c ']]]]);
        $this->render()->shouldBe('name="a  d   b c   d  c "');
    }

    public function it_can_be_boolean()
    {
        $this->beConstructedWith('name');
        $this->isBoolean()->shouldReturn(true);

        $this->setBoolean();
        $this->isBoolean()->shouldReturn(true);

        $this->setBoolean(true);
        $this->isBoolean()->shouldReturn(true);

        $this->setBoolean(false);
        $this->isBoolean()->shouldReturn(false);

        $this->append('a');
        $this->isBoolean()->shouldReturn(false);
        $this->render()->shouldReturn('name="a"');

        $this->setBoolean();
        $this->isBoolean()->shouldReturn(true);

        $this->setBoolean(true);
        $this->isBoolean()->shouldReturn(true);

        $this->setBoolean(false);
        $this->isBoolean()->shouldReturn(false);

        $this->render()->shouldBe('name=""');
        $this->append('b');
        $this->render()->shouldBe('name="b"');
        $this->isBoolean()->shouldReturn(false);

        $this->setBoolean(true);
        $this->isBoolean()->shouldReturn(true);

        $this->render()->shouldBe('name');
    }

    public function it_can_be_casted_as_a_string()
    {
        $this->beConstructedWith('class');
        $this->append('hello world');

        $this->render()->shouldReturn((string) $this->getWrappedObject());
    }

    public function it_can_be_serialized()
    {
        $this->beConstructedWith('class');
        $this->append('hello world');

        $this->serialize()->shouldReturn(
            'a:2:{s:4:"name";s:5:"class";s:6:"values";a:1:{i:0;s:11:"hello world";}}'
        );
    }

    public function it_can_be_unserialized()
    {
        $this->beConstructedWith('class');
        $this->append('hello world');

        $this
            ->unserialize(
                'a:2:{s:4:"name";s:5:"class";s:6:"values";a:1:{i:0;s:11:"hello world";}}'
            );
        $this->getName()->shouldReturn('class');
        $this->getValuesAsArray()->shouldReturn(['hello world']);
        $this->render()->shouldReturn('class="hello world"');
    }

    public function it_can_be_used_like_an_array()
    {
        $this->beConstructedWith('class');
        $this->append('hello');

        $this[] = 'world';
        $this->render()->shouldReturn('class="hello world"');
        $this['anything-here'] = 'anything';
        $this->render()->shouldReturn('class="hello world anything"');

        $this->shouldThrow('\BadMethodCallException')->during(
            'offsetGet',
            ['random']
        );

        unset($this['world']);

        $this->render()->shouldReturn('class="hello anything"');

        $this->contains('hello')->shouldReturn(isset($this['hello']));
    }

    public function it_can_check_if_it_contains_a_value()
    {
        $this->beConstructedWith('name');
        $this->append('hello world', '3.1415');
        $this->contains('world')->shouldReturn(false);
        $this->contains('wor')->shouldReturn(false);
        $this->contains('word')->shouldReturn(false);
        $this->contains('3.1415')->shouldReturn(true);
        $this->contains(3.1415)->shouldReturn(false);
        $this->contains('hello world')->shouldReturn(true);
    }

    public function it_can_delete()
    {
        $this->beConstructedWith('name');
        $this->append('hello world');

        $this->delete()->render()->shouldBe('');
    }

    public function it_can_remove_values()
    {
        $this->beConstructedWith('name', null);
        $this
            ->remove('a')
            ->shouldReturn($this);

        $this
            ->render()
            ->shouldReturn('name');

        $this->append('c b a');
        $this->getValuesAsArray()->shouldBe(['c b a']);
        $this->render()->shouldBe('name="c b a"');
        $this
            ->remove('c b a')
            ->shouldReturn($this);
        $this->getValuesAsArray()->shouldBe([]);
        $this->render()->shouldBe('name');
    }

    public function it_can_render_value_as_string_or_array()
    {
        $this->beConstructedWith('class');
        $this->append(0);
        $this->append('hello');
        $this->append('foo');
        $this->append('bar');
        $this->append('"<a href="#">oops</a>');

        $this->getValuesAsString()->shouldReturn(
            '0 hello foo bar &quot;&lt;a href=&quot;#&quot;&gt;oops&lt;/a&gt;'
        );
        $this->getValuesAsArray()->shouldReturn(
            [
                '0',
                'hello',
                'foo',
                'bar',
                '"<a href="#">oops</a>',
            ]
        );
    }

    public function it_can_replace_values()
    {
        $this->beConstructedWith('name', 'c b a');
        $this
            ->replace('a', 'A')
            ->shouldReturn($this);
        $this->getValuesAsArray()->shouldBe(['c b a']);
        $this->render()->shouldBe('name="c b a"');
        $this->replace('c b a', 'a b c d');
        $this->getValuesAsArray()->shouldBe(['a b c d']);
        $this->render()->shouldBe('name="a b c d"');
    }

    public function it_can_sanitize_its_name_and_value()
    {
        $this
            ->shouldThrow('\InvalidArgumentException')
            ->during('__construct', [' name ', 'plop']);
        $this
            ->shouldThrow('\InvalidArgumentException')
            ->during('__construct', ['na me', 'plop']);
        $this
            ->shouldThrow('\InvalidArgumentException')
            ->during('__construct', ['na"me', 'plop']);

        $this->beConstructedWith(
            'name',
            'this is a"><script>alert("XSS")</script>'
        );
        $this->getName()->shouldBe('name');
        $this->getValuesAsArray()->shouldBe(
            ['this is a"><script>alert("XSS")</script>']
        );
        $this->render()->shouldBe(
            'name="this is a&quot;&gt;&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;"'
        );
    }

    public function it_can_set()
    {
        $this->beConstructedWith('name', 'value');
        $this
            ->set('anything')
            ->shouldReturn($this);

        $this
            ->render()
            ->shouldReturn('name="anything"');
    }

    public function it_is_initializable()
    {
        $this->beConstructedWith('name', 'value');
        $this->shouldHaveType(Attribute::class);
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
