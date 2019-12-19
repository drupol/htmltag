<?php

namespace drupol\htmltag;

use drupol\htmltag\Attribute\AttributeInterface;
use drupol\htmltag\Attributes\AttributesInterface;
use drupol\htmltag\Tag\TagInterface;

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
     * @param array<mixed>|string $value
     *   The attribute value
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public static function attribute($name, $value): AttributeInterface;

    /**
     * Create a new attributes.
     *
     * @param array<mixed> $attributes
     *   The attributes
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public static function attributes(array $attributes = []): AttributesInterface;

    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name
     * @param array<mixed> $attributes
     *   The attributes
     * @param mixed $content
     *   The content
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag
     */
    public static function tag($name, array $attributes = [], $content = null): TagInterface;
}
