<?php

namespace drupol\htmltag\Attributes;

/**
 * Interface AttributesFactoryInterface.
 */
interface AttributesFactoryInterface
{
    /**
     * Create a new attributes.
     *
     * @param array $attributes
     *   The attributes
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public static function build(
        array $attributes = []
    );

    /**
     * Create a new attributes.
     *
     * @param array $attributes
     *   The attributes
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function getInstance(
        array $attributes = []
    );
}
