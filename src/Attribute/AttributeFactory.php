<?php

namespace drupol\htmltag\Attribute;

/**
 * Class AttributeFactory
 */
class AttributeFactory implements AttributeFactoryInterface
{
    /**
     * The attribute classname.
     *
     * @var string
     */
    protected $attribute_classname = Attribute::class;

    /**
     * {@inheritdoc}
     */
    public static function build($name, $value = null, $attribute_classname = null)
    {
        $static = new static();

        return $static->getInstance($name, $value, $attribute_classname);
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance($name, $value = null, $attribute_classname = null)
    {
        $attribute_classname = null == $attribute_classname ?
            $this->attribute_classname :
            $attribute_classname;

        /** @var \drupol\htmltag\Attribute\AttributeInterface $attribute */
        $attribute = (new \ReflectionClass($attribute_classname))
            ->newInstanceArgs([
                $name,
                $value
            ]);

        return $attribute;
    }
}
