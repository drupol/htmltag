<?php

namespace spec\drupol\htmltag\Attributes;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attribute\AttributeInterface;
use drupol\htmltag\Attributes\Attributes;
use drupol\htmltag\StringableInterface;
use PhpSpec\ObjectBehavior;

class AttributesSpec extends ObjectBehavior
{
    public function let(AttributeFactory $attributeFactory)
    {
        $attributeFactory = new AttributeFactory();

        $this->beConstructedWith($attributeFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Attributes::class);
    }

    public function it_should_append_attribute_and_value()
    {
        $this
            ->append('class', 'plop')
            ->render()
            ->shouldBe(' class="plop"');
    }

    public function it_should_append_loner_attribute()
    {
        $this
            ->append('data-closable')
            ->render()
            ->shouldBe(' data-closable');

        $this
            ->append('data-closable')
            ->append('data-closable')
            ->render()
            ->shouldBe(' data-closable');
    }

    public function it_can_append_and_remove()
    {
        $this
            ->append('class', ['foo', 'bar'])
            ->render()
            ->shouldBe(' class="foo bar"');

        $this
            ->append('data-closable')
            ->append('class', 'fool')
            ->render()
            ->shouldBe(' class="foo bar fool" data-closable');

        $this
            ->remove('class', 'fool')
            ->render()
            ->shouldBe(' class="foo bar" data-closable');

        $this
            ->remove('class', 'foo')
            ->remove('class', 'bar')
            ->render()
            ->shouldBe(' class data-closable');

        $this
            ->set('class', null)
            ->render()
            ->shouldBe(' class data-closable');

        $this
            ->delete('class')
            ->delete('data-closable')
            ->render()
            ->shouldBe('');
    }

    public function it_can_remove_a_non_existing_attribute()
    {
        $this->remove('unexisting')->shouldBe($this);
    }

    public function it_can_replace_attribute()
    {
        $this
            ->append('data-closable')
            ->append('class', 'foo');

        $this
            ->replace('woo', 'lol')
            ->shouldReturn($this);

        $this
            ->render()
            ->shouldReturn(' data-closable class="foo"');

        $this
            ->replace('class', 'foo', 'bar fool')
            ->shouldReturn($this);

        $this
            ->replace('class', 'plop', 'plip');

        $this
            ->replace('unknown', 'foo', 'bar fool');

        $this
            ->render()
            ->shouldBe(' data-closable class="bar fool"');
    }

    public function it_can_merge_data()
    {
        $this
            ->append('data-closable')
            ->append('class', 'b');

        $this
            ->merge(
                [
                    'absolute1' => null,
                    'absolute2' => [],
                    'absolute3' => [null],
                    'class' => ['a c'],
                    'empty' => [''],
                    'foo' => 'bar',
                    'nested' => [' a', ' c'],
                ]
            )
            ->shouldReturn($this);

        $this
            ->render()
            ->shouldBe(' data-closable class="b a c" absolute1 absolute2 absolute3 empty="" foo="bar" nested=" a  c"');
    }

    public function it_can_check_if_an_attribute_exists()
    {
        $this
            ->append('data-closable')
            ->append('class', 'b');

        $this
            ->exists('class')
            ->shouldReturn(true);
        $this
            ->exists('XclassX')
            ->shouldReturn(false);

        $this
            ->exists('class', 'b')
            ->shouldReturn(true);
        $this
            ->exists('class', 'c')
            ->shouldReturn(false);

        $this
            ->exists('XclassX', 'c')
            ->shouldReturn(false);

        $this
            ->exists('data-closable')
            ->shouldReturn(true);
    }

    public function it_can_check_if_an_attribute_contains_a_value()
    {
        $this
            ->append('data-closable')
            ->append('class', 'b');

        $this
            ->contains('class', 'b')
            ->shouldReturn(true);

        $this
            ->contains('XclassX', 'b')
            ->shouldReturn(false);
    }

    public function it_can_count()
    {
        $this
            ->count()
            ->shouldReturn(0);

        $this
            ->append('data-closable')
            ->append('class', 'b');

        $this
            ->count()
            ->shouldReturn(2);
    }

    public function it_can_return_array()
    {
        $this
            ->getStorage()
            ->shouldYield(new \ArrayIterator([]));

        $this
            ->append('data-closable')
            ->append('class', 'b')
            ->append('class', 'a c');

        $expected = [
            'data-closable' => [],
            'class' => [
                'b',
                'a c',
            ],
        ];

        $this->getValuesAsArray()->shouldReturn($expected);
    }

    public function it_can_return_an_iterator()
    {
        $this
            ->getIterator()
            ->shouldReturnAnInstanceOf(\Iterator::class);
    }

    public function it_can_return_the_storage()
    {
        $this
            ->getStorage()
            ->shouldYield(new \ArrayIterator([]));

        $this
            ->append('data-closable')
            ->append('class', 'b')
            ->append('class', 'a c');

        $this
            ->getStorage()
            ->shouldBeAnInstanceOf(\ArrayIterator::class);
    }

    public function it_can_render()
    {
        $this
            ->render()
            ->shouldReturn('');

        $this
            ->append('data-closable')
            ->append('class', 'b')
            ->append('class', 'a c')
            ->append('id', 123)
            ->render()
            ->shouldBe(' data-closable class="b a c" id="123"');
    }

    public function it_has_working_offsetget()
    {
        $this['class']
            ->shouldBeAnInstanceOf(AttributeInterface::class);

        $tmp = $this['class'];

        $this['id']
            ->shouldBeAnInstanceOf(AttributeInterface::class);

        $this['class']->shouldBe($tmp);
    }

    public function it_has_working_offsetexists()
    {
        $this
            ->append('data-closable')
            ->append('class', 'b')
            ->append('class', 'a c');

        $this->offsetExists('class')->shouldReturn(true);
        $this->offsetExists('unknown')->shouldReturn(false);
        $this->offsetExists('data-closable')->shouldReturn(true);
    }

    public function it_has_working_offsetunset()
    {
        $this
            ->append('data-closable')
            ->append('class', 'b')
            ->append('class', 'a c');

        $this->offsetUnset('class');
        $this->offsetUnset('unknown');
        $this->offsetExists('class')->shouldReturn(false);
        $this->offsetExists('unknown')->shouldReturn(false);
    }

    public function it_has_working_offsetset()
    {
        $this
            ->append('data-closable')
            ->append('class', 'b')
            ->append('class', 'a c');

        $this->offsetSet('class', 'foo');

        $this
            ->render()
            ->shouldReturn(' data-closable class="foo"');
    }
    
    public function it_has_working_constructor()
    {
        $attributeFactory = new AttributeFactory();

        $this->beConstructedWith(
            $attributeFactory,
            [
                'class' => 'a',
                'class_array' => ['a', 'b', 'c'],
                'data-popup' => null,
                'data-popup-array' => [null, null, null],
                'integer' => 1,
                'integer_array' => [1, 2, 3],
                'double' => 3.141516,
                'double_array' => [3.141516, 2.71828182845],
                'bool_true' => true,
                'bool_true_array' => [true, true, true],
                'bool_false' => false,
                'bool_false_array' => [false, false, false],
                'object' => new \stdClass(),
                'object_array' => [new \stdClass(), new \stdClass(), new \stdClass()],
                'object-printable' => new randomPrintableObject(),
                'object-printable-array' => [new randomPrintableObject(), new randomPrintableObject()],
                'null' => null,
                'null_array' => [null, null, null],
            ]
        );

        $this
            ->render()
            ->shouldReturn(' class="a" class_array="a b c" data-popup data-popup-array integer="1" integer_array="1 2 3" double="3.141516" double_array="3.141516 2.71828182845" bool_true bool_true_array bool_false bool_false_array object object_array object-printable="randomPrintableObject" object-printable-array="randomPrintableObject randomPrintableObject" null null_array');
    }

    public function it_can_return_attributes_without_a_specific_attribute()
    {
        $data =                 [
            'class' => ['a', 'b', 'c'],
            'data-popup' => null,
        ];

        $attributeFactory = new AttributeFactory();

        $this
            ->beConstructedWith(
                $attributeFactory,
                $data
            );

        $this
            ->without('class')
            ->render()
            ->shouldReturn(' data-popup');
    }

    public function it_can_set()
    {
        $data =                 [
            'class' => ['a', 'b', 'c'],
            'data-popup' => null,
        ];

        $attributeFactory = new AttributeFactory();

        $this
            ->beConstructedWith(
                $attributeFactory,
                $data
            );

        $this
            ->set('class', 'foo')
            ->set('data-bar')
            ->render()
            ->shouldReturn(' class="foo" data-popup data-bar');
    }

    public function it_can_import()
    {
        $data =                 [
            'class' => ['a', 'b', 'c'],
            'data-popup' => null,
            'foo' => 'bar',
        ];

        $attributeFactory = new AttributeFactory();

        $this
            ->beConstructedWith(
                $attributeFactory,
                $data
            );

        $import = [
            'class' => ['plop', 'foo'],
            'data-popup' => null,
            'data-test' => [
                'b',
                'a c',
            ],
        ];

        $this
            ->import($import)
            ->render()
            ->shouldReturn(' class="plop foo" data-popup foo="bar" data-test="b a c"');
    }

    public function it_can_be_serialized()
    {
        $this->append('class', 'hello class');
        $this->append('value', 'hello value');

        $this->serialize()->shouldReturn('a:1:{s:7:"storage";a:2:{s:5:"class";a:1:{i:0;s:11:"hello class";}s:5:"value";a:1:{i:0;s:11:"hello value";}}}');
    }

    public function it_can_be_unserialized()
    {
        $this->unserialize('a:1:{s:7:"storage";a:2:{s:5:"class";a:1:{i:0;s:11:"hello class";}s:5:"value";a:1:{i:0;s:11:"hello value";}}}');

        $this->render()->shouldReturn(' class="hello class" value="hello value"');
    }

    public function it_can_be_casted_as_a_string()
    {
        $this->append('class', 'hello class');
        $this->append('value', 'hello value');

        $this->render()->shouldReturn((string) $this->getWrappedObject());
    }
}

class randomPrintableObject implements StringableInterface
{
    public function __toString()
    {
        return 'randomPrintableObject';
    }
}
