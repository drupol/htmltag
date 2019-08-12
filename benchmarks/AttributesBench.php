<?php

declare(strict_types=1);

namespace drupol\htmltag\benchmarks;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attributes\Attributes;
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
     * @Revs({1, 100, 1000})
     * @Iterations(5)
     * @Warmup(10)
     */
    public function benchAttributesRender()
    {
        $attributes = new Attributes($this->attributeFactory, $this->getAttributes());
        $attributes->render();
    }

    /**
     * Init the attribute factory object.
     */
    public function initAttributesRender()
    {
        $this->attributeFactory = new AttributeFactory();
    }
}
