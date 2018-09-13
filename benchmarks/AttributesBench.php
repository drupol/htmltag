<?php

namespace drupol\htmltag\benchmarks;

use drupol\htmltag\Attribute\Attribute;
use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attributes\Attributes;
use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\HtmlTag;
use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;

/**
 * @Groups({"Attributes"})
 * @BeforeMethods({"initAttributesRender"})
 */
class AttributesBench extends AbstractBench
{
    /**
     * @var \drupol\htmltag\Attribute\AttributeFactoryInterface
     */
    private $attributeFactory;

    /**
     * Init the attribute factory object.
     */
    public function initAttributesRender()
    {
        $this->attributeFactory = new AttributeFactory();
    }

    /**
     * @Revs({1, 100, 1000})
     * @Iterations(5)
     * @Warmup(10)
     */
    public function benchAttributesRender()
    {
        $attributes = new Attributes($this->attributeFactory, $this->getAttributes());
        $attributes->render();
    }
}
