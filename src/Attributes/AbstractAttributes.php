<?php

declare(strict_types=1);

namespace drupol\htmltag\Attributes;

use ArrayIterator;
use drupol\htmltag\AbstractBaseHtmlTagObject;
use drupol\htmltag\Attribute\AttributeFactoryInterface;

/**
 * Class Attributes.
 */
abstract class AbstractAttributes extends AbstractBaseHtmlTagObject implements AttributesInterface
{
    /**
     * The attribute factory.
     *
     * @var \drupol\htmltag\Attribute\AttributeFactoryInterface
     */
    private $attributeFactory;

    /**
     * Stores the attribute data.
     *
     * @var \drupol\htmltag\Attribute\AttributeInterface[]
     */
    private $storage = [];

    /**
     * Attributes constructor.
     *
     * @param \drupol\htmltag\Attribute\AttributeFactoryInterface $attributeFactory
     *   The attribute factory
     * @param mixed[] $data
     *   The input attributes
     */
    public function __construct(AttributeFactoryInterface $attributeFactory, array $data = [])
    {
        $this->attributeFactory = $attributeFactory;
        $this->import($data);
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
    public function append($key, ...$values): AttributesInterface
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
    public function contains($key, ...$values): bool
    {
        return $this->exists($key) && $this->storage[$key]->contains($values);
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
    public function delete(...$keys): AttributesInterface
    {
        foreach ($this->ensureStrings($this->ensureFlatArray($keys)) as $key) {
            unset($this->storage[$key]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key, ...$values): bool
    {
        if (!isset($this->storage[$key])) {
            return false;
        }

        return [] === $values ?
            true :
            $this->contains($key, $values);
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
    public function getStorage(): ArrayIterator
    {
        return new ArrayIterator(array_values($this->preprocess($this->storage)));
    }

    /**
     * {@inheritdoc}
     */
    public function getValuesAsArray(): array
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
    public function import($data): AttributesInterface
    {
        foreach ($data as $key => $value) {
            $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function merge(array ...$dataset): AttributesInterface
    {
        foreach ($dataset as $data) {
            foreach ($data as $key => $value) {
                $this->append($key, $value);
            }
        }

        return $this;
    }

    /**
     * @param int $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return isset($this->storage[$key]);
    }

    /**
     * @param int $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        $this->storage += [
            $key => $this->attributeFactory->getInstance((string) $key),
        ];

        return $this->storage[$key];
    }

    /**
     * @param int $key
     * @param mixed|null $value
     *
     * @return void
     */
    public function offsetSet($key, $value = null)
    {
        $this->storage[$key] = $this->attributeFactory->getInstance((string) $key, $value);
    }

    /**
     * @param int $key
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->storage[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function preprocess(array $values, array $context = []): array
    {
        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key, ...$values): AttributesInterface
    {
        if (isset($this->storage[$key])) {
            $this->storage[$key]->remove($values);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render(): string
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
    public function replace($key, $value, ...$replacements): AttributesInterface
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
    public function serialize()
    {
        return serialize([
            'storage' => $this->getValuesAsArray(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, ...$value): AttributesInterface
    {
        $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $unserialize = unserialize($serialized);
        $attributeFactory = $this->attributeFactory;

        $this->storage = array_map(
            static function ($key, $values) use ($attributeFactory) {
                return $attributeFactory::build((string) $key, $values);
            },
            array_keys($unserialize['storage']),
            array_values($unserialize['storage'])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function without(...$keys): AttributesInterface
    {
        $attributes = clone $this;

        return $attributes->delete($keys);
    }
}
