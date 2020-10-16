<?php

declare(strict_types=1);

namespace drupol\htmltag\Attribute;

use Exception;
use ReflectionClass;

use function in_array;

/**
 * Class AttributeFactory.
 */
class AttributeFactory implements AttributeFactoryInterface
{
    /**
     * The classes registry.
     *
     * @var array<string, string>
     */
    public static $registry = [
        '*' => Attribute::class,
    ];

    /**
     * {@inheritdoc}
     */
    public static function build($name, $value = null): AttributeInterface
    {
        return (new static())->getInstance($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance($name, $value = null): AttributeInterface
    {
        $attribute_classname = static::$registry[$name] ?? static::$registry['*'];

        if (!in_array(AttributeInterface::class, class_implements($attribute_classname), true)) {
            throw new Exception(
                sprintf(
                    'The class (%s) must implement the interface %s.',
                    $attribute_classname,
                    AttributeInterface::class
                )
            );
        }

        /** @var \drupol\htmltag\Attribute\AttributeInterface $attribute */
        $attribute = (new ReflectionClass($attribute_classname))
            ->newInstanceArgs([
                $name,
                $value,
            ]);

        return $attribute;
    }
}
