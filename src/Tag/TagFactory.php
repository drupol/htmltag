<?php

declare(strict_types=1);

namespace drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Attributes\AttributesInterface;
use Exception;
use ReflectionClass;

use function in_array;

class TagFactory implements TagFactoryInterface
{
    /**
     * The classes registry.
     *
     * @var array<string, string>
     */
    public static $registry = [
        'attributes_factory' => AttributesFactory::class,
        '!--' => Comment::class,
        '*' => Tag::class,
    ];

    public static function build(
        string $name,
        array $attributes = [],
        $content = null
    ): TagInterface {
        return (new static())->getInstance($name, $attributes, $content);
    }

    public function getInstance(
        string $name,
        array $attributes = [],
        $content = null
    ): TagInterface {
        $attributes_factory_classname = static::$registry['attributes_factory'];

        /** @var AttributesInterface $attributes */
        $attributes = $attributes_factory_classname::build($attributes);

        $tag_classname = static::$registry[$name] ?? static::$registry['*'];

        if (!in_array(TagInterface::class, class_implements($tag_classname), true)) {
            throw new Exception(
                sprintf(
                    'The class (%s) must implement the interface %s.',
                    $tag_classname,
                    TagInterface::class
                )
            );
        }

        /** @var \drupol\htmltag\Tag\TagInterface $tag */
        $tag = (new ReflectionClass($tag_classname))
            ->newInstanceArgs([
                $attributes,
                $name,
                $content,
            ]);

        return $tag;
    }
}
