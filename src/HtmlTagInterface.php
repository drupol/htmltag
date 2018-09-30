<?php

namespace drupol\htmltag;

use drupol\htmltag\Attribute\AttributeFactoryInterface;
use drupol\htmltag\Attributes\AttributesFactoryInterface;

/**
 * Interface HtmlTagInterface
 */
interface HtmlTagInterface
{
    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name.
     * @param array $attributes
     *   The attributes.
     * @param mixed $content
     *   The content.
     * @param string|null $attribute_factory_classname
     *   The attribute factory class name.
     * @param string|null $attributes_factory_classname
     *   The attributes factory class name.
     * @param string|null $tag_factory_classname
     *   The tag factory class name.
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag.
     */
    public static function tag(
        $name,
        array $attributes = [],
        $content = null,
        $attribute_factory_classname = null,
        $attributes_factory_classname = null,
        $tag_factory_classname = null
    );

    /**
     * Create a new attributes.
     *
     * @param array $attributes
     *   The attributes.
     * @param string|null $attribute_factory_classname
     *   The attribute factory class name.
     * @param string|null $attributes_factory_classname
     *   The attributes factory class name.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public static function attributes(
        array $attributes = [],
        $attribute_factory_classname = null,
        $attributes_factory_classname = null
    );

    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name.
     * @param string|string[]|mixed[] $value
     *   The attribute value.
     * @param string|null $attribute_factory_classname
     *   The attribute factory class name.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute.
     */
    public static function attribute(
        $name,
        $value,
        $attribute_factory_classname = null
    );
}
