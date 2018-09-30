<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\AlterableInterface;
use drupol\htmltag\RenderableInterface;
use drupol\htmltag\StringableInterface;

/**
 * Interface TagInterface.
 */
interface TagInterface extends \Serializable, RenderableInterface, StringableInterface, AlterableInterface
{
    /**
     * Get the attributes as string or a specific attribute if $name is provided.
     *
     * @param string $name
     *   The name of the attribute.
     *
     * @param mixed ...$value
     *   The value.
     *
     * @return string|\drupol\htmltag\Attribute\AttributeInterface
     *   The attributes as string or a specific Attribute object.
     */
    public function attr($name = null, ...$value);

    /**
     * Set or get the content.
     *
     * @param mixed ...$data
     *   The content.
     *
     * @return string|null
     *   The content.
     */
    public function content(...$data);

    /**
     * Get the content.
     *
     * @return array
     *   The content as an array.
     */
    public function getContentAsArray();
}
