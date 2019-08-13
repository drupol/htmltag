<?php

namespace drupol\htmltag\Attribute;

/**
 * Class AttributeFactory.
 */
class AttributeFactory implements AttributeFactoryInterface
{
    /**
     * The classes registry.
     *
     * @var array
     */
    public static $registry = [
        '*' => Attribute::class,
    ];

    /**
     * {@inheritdoc}
     */
    public static function build($name, $value = null)
    {
        return (new static())->getInstance($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance($name, $value = null)
    {
        $attribute_classname = isset(static::$registry[$name]) ?
            static::$registry[$name] :
            static::$registry['*'];

        if (!\in_array(AttributeInterface::class, \class_implements($attribute_classname), true)) {
            throw new \Exception(
                \sprintf(
                    'The class (%s) must implement the interface %s.',
                    $attribute_classname,
                    AttributeInterface::class
                )
            );
        }

        /** @var \drupol\htmltag\Attribute\AttributeInterface $attribute */
        $attribute = (new \ReflectionClass($attribute_classname))
            ->newInstanceArgs([
                $name,
                $value,
            ]);

        return $attribute;
    }
}
