<?php

namespace drupol\htmltag;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Tag\TagFactory;

/**
 * Class HtmlTag.
 */
final class HtmlTag implements HtmlTagInterface
{
    /**
     * {@inheritdoc}
     */
    public static function attribute($name, $value)
    {
        return AttributeFactory::build($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public static function attributes(array $attributes = [])
    {
        return AttributesFactory::build($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public static function tag($name, array $attributes = [], $content = null)
    {
        return TagFactory::build($name, $attributes, $content);
    }
}
