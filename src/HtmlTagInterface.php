<?php

namespace drupol\htmltag;

/**
 * Interface HtmlTagInterface.
 */
interface HtmlTagInterface
{
    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name
     * @param mixed[]|string|string[] $value
     *   The attribute value
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public static function attribute($name, $value);

    /**
     * Create a new attributes.
     *
     * @param array $attributes
     *   The attributes
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public static function attributes(array $attributes = []);

    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name
     * @param array $attributes
     *   The attributes
     * @param mixed $content
     *   The content
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag
     */
    public static function tag($name, array $attributes = [], $content = null);
}
