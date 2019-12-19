<?php

namespace drupol\htmltag\Attribute;

/**
 * Interface AttributeFactoryInterface.
 */
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
    public static function build($name, $value = null): AttributeInterface;

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
    public function getInstance($name, $value = null): AttributeInterface;
}
