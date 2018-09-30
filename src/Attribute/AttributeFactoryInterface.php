<?php

namespace drupol\htmltag\Attribute;

/**
 * Interface AttributeFactoryInterface
 */
interface AttributeFactoryInterface
{
    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name.
     * @param string|mixed[]|null $value
     *   The attribute value.
     * @param string|null $attribute_classname
     *   The attribute class name.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute.
     */
    public static function build($name, $value = null, $attribute_classname = null);

    /**
     * Create a new attribute.
     *
     * @param string $name
     *   The attribute name.
     * @param string|mixed[]|null $value
     *   The attribute value.
     * @param string|null $attribute_classname
     *   The attribute class name.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute.
     */
    public function getInstance($name, $value = null, $attribute_classname = null);
}
