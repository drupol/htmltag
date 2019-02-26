<?php

namespace drupol\htmltag\Tag;

/**
 * Interface TagFactoryInterface.
 */
interface TagFactoryInterface
{
    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name
     * @param array $attributes
     *   The tag attributes
     * @param mixed $content
     *   The tag content
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag
     */
    public static function build($name, array $attributes = [], $content = null);

    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name
     * @param array $attributes
     *   The tag attributes
     * @param mixed $content
     *   The tag content
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag
     */
    public function getInstance($name, array $attributes = [], $content = null);
}
