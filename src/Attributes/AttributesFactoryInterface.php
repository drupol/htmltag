<?php

namespace drupol\htmltag\Attributes;

/**
 * Interface AttributesFactoryInterface
 */
interface AttributesFactoryInterface
{
    /**
     * Create a new attributes.
     *
     * @param array $attributes
     *   The attributes.
     * @param string|null $attribute_factory_classname
     *   The attribute factory classname.
     * @param string|null $attributes_classname
     *   The attributes classname.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public static function build(
        array $attributes = [],
        $attribute_factory_classname = null,
        $attributes_classname = null
    );

    /**
     * Create a new attributes.
     *
     * @param array $attributes
     *   The attributes.
     * @param string|null $attribute_factory_classname
     *   The attribute factory classname.
     * @param string|null $attributes_classname
     *   The attributes classname.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function getInstance(
        array $attributes = [],
        $attribute_factory_classname = null,
        $attributes_classname = null
    );
}
