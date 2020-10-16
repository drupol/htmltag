<?php

declare(strict_types=1);

namespace drupol\htmltag\Attribute;

use BadMethodCallException;
use drupol\htmltag\AbstractBaseHtmlTagObject;
use InvalidArgumentException;

use function count;
use function in_array;

use const ENT_QUOTES;
use const ENT_SUBSTITUTE;

/**
 * Class Attribute.
 */
abstract class AbstractAttribute extends AbstractBaseHtmlTagObject implements AttributeInterface
{
    /**
     * Store the attribute name.
     *
     * @var string
     */
    private $name;

    /**
     * Store the attribute value.
     *
     * @var array<mixed>
     */
    private $values;

    /**
     * Attribute constructor.
     *
     * @param string $name
     *   The attribute name
     * @param mixed[]|string|string[] ...$values
     *   The attribute values.
     */
    public function __construct(string $name, ...$values)
    {
        if (1 === preg_match('/[\t\n\f \/>"\'=]+/', $name)) {
            // @todo: create exception class for this.
            throw new InvalidArgumentException('Attribute name is not valid.');
        }

        $this->name = $name;
        $this->values = $values;
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
    public function alter(callable ...$closures): AttributeInterface
    {
        foreach ($closures as $closure) {
            $this->values = $closure(
                $this->ensureFlatArray($this->values),
                $this->name
            );
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function append(...$value): AttributeInterface
    {
        $this->values[] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function contains(...$substring): bool
    {
        $values = $this->ensureFlatArray($this->values);

        return !in_array(
            false,
            array_map(
                static function ($substring_item) use ($values) {
                    return in_array($substring_item, $values, true);
                },
                $this->ensureFlatArray($substring)
            ),
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete(): AttributeInterface
    {
        $this->name = '';
        $this->values = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function escape($value): string
    {
        return null === $value ?
                $value :
                htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValuesAsArray(): array
    {
        return $this->ensureStrings(
            $this->preprocess(
                $this->ensureFlatArray($this->values),
                ['name' => $this->name]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getValuesAsString(): ?string
    {
        return [] === ($values = $this->getValuesAsArray()) ?
            null :
            (string) $this->escape(implode(' ', array_filter($values, '\strlen')));
    }

    /**
     * {@inheritdoc}
     */
    public function isBoolean(): bool
    {
        return [] === $this->getValuesAsArray();
    }

    /**
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->contains((string) $offset);
    }

    /**
     * @param int $offset
     *
     * @return void
     */
    public function offsetGet($offset)
    {
        throw new BadMethodCallException('Unsupported method.');
    }

    /**
     * @param int $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->append($value);
    }

    /**
     * @param int $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->remove((string) $offset);
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
    public function remove(...$value): AttributeInterface
    {
        return $this->set(
            array_diff(
                $this->ensureFlatArray($this->values),
                $this->ensureFlatArray($value)
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render(): string
    {
        return null === ($values = $this->getValuesAsString()) ?
            $this->name :
            $this->name . '="' . $values . '"';
    }

    /**
     * {@inheritdoc}
     */
    public function replace($original, ...$replacement): AttributeInterface
    {
        $count_start = count($this->ensureFlatArray($this->values));
        $this->remove($original);

        if (count($this->ensureFlatArray($this->values)) !== $count_start) {
            $this->append($replacement);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            'name' => $this->name,
            'values' => $this->getValuesAsArray(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function set(...$value): AttributeInterface
    {
        $this->values = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBoolean($boolean = true): AttributeInterface
    {
        return true === $boolean ?
            $this->set() :
            $this->append('');
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);

        $this->name = $unserialized['name'];
        $this->values = $unserialized['values'];
    }
}
