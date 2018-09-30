<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Attributes\AttributesInterface;

/**
 * Class CommentFactory
 */
class CommentFactory extends TagFactory
{
    /**
     * The Comment classname.
     *
     * @var string
     */
    protected $comment_classname = Comment::class;

    /**
     * The Tag classname.
     *
     * @var string
     */
    protected $tag_classname = Tag::class;

    /**
     * The attributes factory classname.
     *
     * @var string
     */
    protected $attributes_factory_classname = AttributesFactory::class;

    /**
     * {@inheritdoc}
     */
    public static function build(
        $content,
        array $attributes = [],
        $name = null,
        $attribute_factory_classname = null,
        $attributes_factory_classname = null,
        $comment_classname = null
    ) {
        $static = new static;

        return $static->getInstance(
            $content,
            $attributes,
            $name,
            $attribute_factory_classname,
            $attributes_factory_classname,
            $comment_classname
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance(
        $content,
        array $attributes = [],
        $name = null,
        $attribute_factory_classname = null,
        $attributes_factory_classname = null,
        $comment_classname = null
    ) {
        $comment_classname = null === $comment_classname ?
            $this->comment_classname:
            $comment_classname;

        /** @var \drupol\htmltag\Tag\TagInterface $tag */
        $tag = (new \ReflectionClass($comment_classname))
            ->newInstanceArgs([
                $content,
            ]);

        return $tag;
    }
}
