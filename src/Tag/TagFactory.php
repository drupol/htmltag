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
     * The classes registry.
     *
     * @var array
     */
    public static $registry = [
        '!--' => Comment::class,
        '*' => Tag::class
    ];

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
        $attributes_factory_classname = null
    ) {
        $static = new static;

        return $static->getInstance(
            $name,
            $attributes,
            $content,
            $attribute_factory_classname,
            $attributes_factory_classname
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
        $attributes_factory_classname = null
    ) {
        $attributes_factory_classname = null === $attributes_factory_classname ?
            $this->attributes_factory_classname:
            $attributes_factory_classname;

        /** @var AttributesInterface $attributes */
        $attributes = $attributes_factory_classname::build(
            $attributes,
            $attribute_factory_classname
        );

        $tag_classname = isset(static::$registry[$name]) ?
            static::$registry[$name] :
            static::$registry['*'] ;

        if (!in_array(TagInterface::class, class_implements($tag_classname), true)) {
            throw new \Exception(
                sprintf(
                    'The class (%s) must implement the interface %s.',
                    $tag_classname,
                    TagInterface::class
                )
            );
        }

        /** @var \drupol\htmltag\Tag\TagInterface $tag */
        $tag = (new \ReflectionClass($tag_classname))
            ->newInstanceArgs([
                $attributes,
                $name,
                $content,
            ]);

        return $tag;
    }
}
