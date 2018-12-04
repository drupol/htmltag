<?php

namespace drupol\htmltag;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Tag\CommentFactory;
use drupol\htmltag\Tag\TagFactory;

/**
 * Class HtmlTag
 */
class HtmlTag implements HtmlTagInterface
{
    /**
     * The attribute factory classname.
     *
     * @var string
     */
    protected $attribute_factory_classname = AttributeFactory::class;

    /**
     * The attributes factory classname.
     *
     * @var string
     */
    protected $attributes_factory_classname = AttributesFactory::class;

    /**
     * The tag factory classname.
     *
     * @var string
     */
    protected $tag_factory_classname = TagFactory::class;

    /**
     * {@inheritdoc}
     */
    public static function tag(
        $name,
        array $attributes = [],
        $content = null,
        $attribute_factory_classname = null,
        $attributes_factory_classname = null,
        $tag_factory_classname = null
    ) {
        $static = new static();

        $attributes_factory_classname = null == $attributes_factory_classname ?
            $static->attributes_factory_classname :
            $attributes_factory_classname;

        $attribute_factory_classname = null == $attribute_factory_classname ?
            $static->attribute_factory_classname :
            $attribute_factory_classname;

        $tag_factory_classname = null == $tag_factory_classname ?
            $static->tag_factory_classname :
            $tag_factory_classname;
        /** @var \drupol\htmltag\Tag\TagFactoryInterface $tag_factory_classname */
        $tag_factory_classname = (new \ReflectionClass($tag_factory_classname))->newInstance();

        return $tag_factory_classname::build(
            $name,
            $attributes,
            $content,
            $attribute_factory_classname,
            $attributes_factory_classname
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function attributes(
        array $attributes = [],
        $attribute_factory_classname = null,
        $attributes_factory_classname = null
    ) {
        $static = new static();

        $attribute_factory_classname = null == $attribute_factory_classname ?
            $static->attribute_factory_classname :
            $attribute_factory_classname;

        $attributes_factory_classname = null == $attributes_factory_classname ?
            $static->attributes_factory_classname :
            $attributes_factory_classname;

        /** @var \drupol\htmltag\Attributes\AttributesFactoryInterface $attributes_factory_classname */
        $attributes_factory_classname = (new \ReflectionClass($attributes_factory_classname))->newInstance();

        return $attributes_factory_classname::build(
            $attributes,
            $attribute_factory_classname
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function attribute(
        $name,
        $value,
        $attribute_factory_classname = null
    ) {
        $static = new static();

        $attribute_factory_classname = null == $attribute_factory_classname ?
            $static->attribute_factory_classname :
            $attribute_factory_classname;

        /** @var \drupol\htmltag\Attribute\AttributeFactoryInterface $attribute_factory_classname */
        $attribute_factory_classname = (new \ReflectionClass($attribute_factory_classname))->newInstance();

        return $attribute_factory_classname::build($name, $value);
    }
}
