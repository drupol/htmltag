<?php

declare(strict_types=1);

namespace drupol\htmltag\Attribute;

interface AttributeFactoryInterface
{
    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name
     * @param mixed[]|string|null $value
     *   The attribute value
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public static function build(string $name, $value = null): AttributeInterface;

    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name
     * @param mixed[]|string|null $value
     *   The attribute value
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function getInstance(string $name, $value = null): AttributeInterface;
}
