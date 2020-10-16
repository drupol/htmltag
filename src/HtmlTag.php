<?php

declare(strict_types=1);

namespace drupol\htmltag;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attribute\AttributeInterface;
use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Attributes\AttributesInterface;
use drupol\htmltag\Tag\TagFactory;
use drupol\htmltag\Tag\TagInterface;

/**
 * Class HtmlTag.
 */
final class HtmlTag implements HtmlTagInterface
{
    public static function attribute(string $name, $value): AttributeInterface
    {
        return AttributeFactory::build($name, $value);
    }

    public static function attributes(array $attributes = []): AttributesInterface
    {
        return AttributesFactory::build($attributes);
    }

    public static function tag(string $name, array $attributes = [], $content = null): TagInterface
    {
        return TagFactory::build($name, $attributes, $content);
    }
}
