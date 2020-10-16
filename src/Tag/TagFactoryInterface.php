<?php

declare(strict_types=1);

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
     * @param array<mixed> $attributes
     *   The tag attributes
     * @param mixed $content
     *   The tag content
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag
     */
    public static function build($name, array $attributes = [], $content = null): TagInterface;

    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name
     * @param array<mixed> $attributes
     *   The tag attributes
     * @param mixed $content
     *   The tag content
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag
     */
    public function getInstance($name, array $attributes = [], $content = null): TagInterface;
}
