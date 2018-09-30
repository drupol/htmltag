<?php

namespace drupol\htmltag\Attributes;

use drupol\htmltag\Attribute\AttributeFactory;

/**
 * Class AttributesFactory
 */
class AttributesFactory implements AttributesFactoryInterface
{
    /**
     * The attribute factory classname.
     *
     * @var string
     */
    protected $attribute_factory_classname = AttributeFactory::class;

    /**
     * The attributes classname.
     *
     * @var string
     */
    protected $attributes_classname = Attributes::class;

    /**
     * {@inheritdoc}
     */
    public static function build(
        array $attributes = [],
        $attribute_factory_classname = null,
        $attributes_classname = null
    ) {
        $static = new static();

        return $static->getInstance(
            $attributes,
            $attribute_factory_classname,
            $attributes_classname
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance(
        array $attributes = [],
        $attribute_factory_classname = null,
        $attributes_classname = null
    ) {
        $attribute_factory_classname = null == $attribute_factory_classname ?
            $this->attribute_factory_classname :
            $attribute_factory_classname;

        /** @var \drupol\htmltag\Attribute\AttributeFactoryInterface $attribute_factory_classname */
        $attribute_factory_classname = (new \ReflectionClass($attribute_factory_classname))->newInstance();

        $attributes_classname = null == $attributes_classname ?
            $this->attributes_classname :
            $attributes_classname;

        /** @var \drupol\htmltag\Attributes\AttributesInterface $attributes */
        $attributes = (new \ReflectionClass($attributes_classname))
            ->newInstanceArgs([
                $attribute_factory_classname,
                $attributes
            ]);

        return $attributes;
    }
}
