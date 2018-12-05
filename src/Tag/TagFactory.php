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
        'attributes_factory' => AttributesFactory::class,
        '!--' => Comment::class,
        '*' => Tag::class,
    ];

    /**
     * {@inheritdoc}
     */
    public static function build(
        $name,
        array $attributes = [],
        $content = null
    ) {
        return (new static())->getInstance($name, $attributes, $content);
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance(
        $name,
        array $attributes = [],
        $content = null
    ) {
        $attributes_factory_classname = static::$registry['attributes_factory'];

        /** @var AttributesInterface $attributes */
        $attributes = $attributes_factory_classname::build($attributes);

        $tag_classname = isset(static::$registry[$name]) ?
            static::$registry[$name] :
            static::$registry['*'] ;

        if (!\in_array(TagInterface::class, \class_implements($tag_classname), true)) {
            throw new \Exception(
                \sprintf(
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
