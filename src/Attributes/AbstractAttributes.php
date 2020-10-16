<?php

declare(strict_types=1);

namespace drupol\htmltag\Attributes;

use ArrayIterator;
use drupol\htmltag\AbstractBaseHtmlTagObject;
use drupol\htmltag\Attribute\AttributeFactoryInterface;

use function array_key_exists;

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
     * @var array<string, AttributesInterface>
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

    public function __toString(): string
    {
        return $this->render();
    }

    public function append($key, ...$values): AttributesInterface
    {
        $this->storage += [
            $key => $this->attributeFactory->getInstance($key),
        ];

        $this->storage[$key]->append($values);

        return $this;
    }

    public function contains(string $key, ...$values): bool
    {
        return $this->exists($key) && $this->storage[$key]->contains(...$values);
    }

    public function count()
    {
        return $this->getStorage()->count();
    }

    public function delete(string ...$keys): AttributesInterface
    {
        foreach ($this->ensureStrings($this->ensureFlatArray($keys)) as $key) {
            unset($this->storage[$key]);
        }

        return $this;
    }

    public function exists(string $key, ...$values): bool
    {
        if (!isset($this->storage[$key])) {
            return false;
        }

        return [] === $values ?
            true :
            $this->contains($key, $values);
    }

    public function getIterator()
    {
        return $this->getStorage();
    }

    public function getStorage(): ArrayIterator
    {
        return new ArrayIterator(array_values($this->preprocess($this->storage)));
    }

    public function getValuesAsArray(): array
    {
        $values = [];

        foreach ($this->getStorage() as $attribute) {
            $values[$attribute->getName()] = $attribute->getValuesAsArray();
        }

        return $values;
    }

    public function import($data): AttributesInterface
    {
        foreach ($data as $key => $value) {
            $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);
        }

        return $this;
    }

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
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($key, $value)
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

    public function preprocess(array $values, array $context = []): array
    {
        return $values;
    }

    public function remove(string $key, ...$values): AttributesInterface
    {
        if (array_key_exists($key, $this->storage)) {
            $this->storage[$key]->remove(...$values);
        }

        return $this;
    }

    public function render(): string
    {
        $output = '';

        foreach ($this->getStorage() as $attribute) {
            $output .= ' ' . $attribute;
        }

        return $output;
    }

    public function replace(string $key, string $value, string ...$replacements): AttributesInterface
    {
        if (!$this->contains($key, $value)) {
            return $this;
        }

        $this->storage[$key]->replace($value, ...$replacements);

        return $this;
    }

    public function serialize()
    {
        return serialize([
            'storage' => $this->getValuesAsArray(),
        ]);
    }

    public function set(string $key, ...$value): AttributesInterface
    {
        $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);

        return $this;
    }

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

    public function without(string ...$keys): AttributesInterface
    {
        $attributes = clone $this;

        return $attributes->delete(...$keys);
    }
}
