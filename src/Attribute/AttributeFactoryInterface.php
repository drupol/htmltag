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
     * @param null|mixed[]|string $value
     *   The attribute value
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public static function build($name, $value = null);

    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name
     * @param null|mixed[]|string $value
     *   The attribute value
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function getInstance($name, $value = null);
}
