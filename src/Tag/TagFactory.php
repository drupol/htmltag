<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Attributes\AttributesInterface;

/**
 * Class TagFactory
 */
class TagFactory implements TagFactoryInterface
{
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
        $name,
        array $attributes = [],
        $content = null,
        $attribute_factory_classname = null,
        $attributes_factory_classname = null,
        $tag_classname = null
    ) {
        $static = new static;

        return $static->getInstance(
            $name,
            $attributes,
            $content,
            $attribute_factory_classname,
            $attributes_factory_classname,
            $tag_classname
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance(
        $name,
        array $attributes = [],
        $content = null,
        $attribute_factory_classname = null,
        $attributes_factory_classname = null,
        $comment_classname = null
    ) {
        $attributes_factory_classname = null === $attributes_factory_classname ?
            $this->attributes_factory_classname:
            $attributes_factory_classname;

        /** @var AttributesInterface $attributes */
        $attributes = $attributes_factory_classname::build(
            $attributes,
            $attribute_factory_classname
        );

        $comment_classname = null === $comment_classname ?
            $this->tag_classname:
            $comment_classname;

        /** @var \drupol\htmltag\Tag\TagInterface $tag */
        $tag = (new \ReflectionClass($comment_classname))
            ->newInstanceArgs([
                $attributes,
                $name,
                $content,
            ]);

        return $tag;
    }
}
