<?php

namespace drupol\htmltag\Tag;

/**
 * Interface TagFactoryInterface
 */
interface TagFactoryInterface
{
    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name.
     * @param array $attributes
     *   The tag attributes.
     * @param mixed $content
     *   The tag content.
     * @param string|null $attribute_factoryclassname_classname
     *   The attribute factory classname.
     * @param string|null $attributes_factoryclassname_classname
     *   The attributes factory classname.
     * @param string|null $tag_classname
     *   The tag classname.
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag.
     */
    public static function build(
        $name,
        array $attributes = [],
        $content = null,
        $attribute_factoryclassname_classname = null,
        $attributes_factoryclassname_classname = null,
        $tag_classname = null
    );

    /**
     * Create a new tag.
     *
     * @param string $name
     *   The tag name.
     * @param array $attributes
     *   The tag attributes.
     * @param mixed $content
     *   The tag content.
     * @param string|null $attribute_factoryclassname_classname
     *   The attribute factory classname.
     * @param string|null $attributes_factoryclassname_classname
     *   The attributes factory classname.
     * @param string|null $comment_classname
     *   The tag classname.
     *
     * @return \drupol\htmltag\Tag\TagInterface
     *   The tag.
     */
    public function getInstance(
        $name,
        array $attributes = [],
        $content = null,
        $attribute_factoryclassname_classname = null,
        $attributes_factoryclassname_classname = null,
        $comment_classname = null
    );
}
