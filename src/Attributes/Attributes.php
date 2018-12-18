<?php

namespace drupol\htmltag\Attributes;

use drupol\htmltag\AbstractBaseHtmlTagObject;
use drupol\htmltag\Attribute\AttributeFactoryInterface;

/**
 * Class Attributes.
 */
class Attributes extends AbstractBaseHtmlTagObject implements AttributesInterface
{
    /**
     * Stores the attribute data.
     *
     * @var \drupol\htmltag\Attribute\AttributeInterface[]
     */
    private $storage = [];

    /**
     * The attribute factory.
     *
     * @var \drupol\htmltag\Attribute\AttributeFactoryInterface
     */
    private $attributeFactory;

    /**
     * Attributes constructor.
     *
     * @param \drupol\htmltag\Attribute\AttributeFactoryInterface $attributeFactory
     *   The attribute factory.
     * @param mixed[] $data
     *   The input attributes.
     */
    public function __construct(AttributeFactoryInterface $attributeFactory, array $data = [])
    {
        $this->attributeFactory = $attributeFactory;
        $this->import($data);
    }

    /**
     * {@inheritdoc}
     */
    public function import($data)
    {
        foreach ($data as $key => $value) {
            $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, ...$value)
    {
        $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($key)
    {
        $this->storage += [
            $key => $this->attributeFactory->getInstance($key),
        ];

        return $this->storage[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($key, $value = null)
    {
        $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($key)
    {
        unset($this->storage[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($key)
    {
        return isset($this->storage[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function append($key, ...$values)
    {
        $this->storage += [
            $key => $this->attributeFactory->getInstance($key),
        ];

        $this->storage[$key]->append($values);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key, ...$values)
    {
        if (isset($this->storage[$key])) {
            $this->storage[$key]->remove($values);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(...$keys)
    {
        foreach ($this->ensureStrings($this->ensureFlatArray($keys)) as $key) {
            unset($this->storage[$key]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function without(...$keys)
    {
        $attributes = clone $this;

        return $attributes->delete($keys);
    }

    /**
     * {@inheritdoc}
     */
    public function replace($key, $value, ...$replacements)
    {
        if (!$this->contains($key, $value)) {
            return $this;
        }

        $this->storage[$key]->replace($value, $replacements);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function merge(array ...$dataset)
    {
        foreach ($dataset as $data) {
            foreach ($data as $key => $value) {
                $this->append($key, $value);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key, ...$values)
    {
        if (!isset($this->storage[$key])) {
            return false;
        }

        return [] == $values ?
            true:
            $this->contains($key, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($key, ...$values)
    {
        return $this->exists($key) && $this->storage[$key]->contains($values);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        foreach ($this->getStorage() as $attribute) {
            $output .= ' ' . $attribute;
        }
        
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function getStorage()
    {
        return new \ArrayIterator(\array_values($this->preprocess($this->storage)));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->getStorage();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->getStorage()->count();
    }

    /**
     * {@inheritdoc}
     */
    public function getValuesAsArray()
    {
        $values = [];

        foreach ($this->getStorage() as $attribute) {
            $values[$attribute->getName()] = $attribute->getValuesAsArray();
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return \serialize([
            'storage' => $this->getValuesAsArray(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $unserialize = \unserialize($serialized);
        $attributeFactory = $this->attributeFactory;

        $this->storage = \array_map(
            function ($key, $values) use ($attributeFactory) {
                return $attributeFactory::build($key, $values);
            },
            \array_keys($unserialize['storage']),
            \array_values($unserialize['storage'])
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function escape($value)
    {
        throw new \BadMethodCallException('Unsupported method.');
    }
}
