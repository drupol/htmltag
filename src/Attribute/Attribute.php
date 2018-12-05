<?php

namespace drupol\htmltag\Attribute;

use drupol\htmltag\AbstractBaseHtmlTagObject;

/**
 * Class Attribute.
 */
class Attribute extends AbstractBaseHtmlTagObject implements AttributeInterface
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
     * @var array
     */
    private $values;

    /**
     * Attribute constructor.
     *
     * @param string $name
     *   The attribute name.
     * @param string|string[]|mixed[] ...$values
     *   The attribute values.
     */
    public function __construct($name, ...$values)
    {
        if (1 == \preg_match('/[\t\n\f \/>"\'=]+/', $name)) {
            // @todo: create exception class for this.
            throw new \InvalidArgumentException('Attribute name is not valid.');
        }

        $this->name = $name;
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->contains($offset);
    }
    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        throw new \BadMethodCallException('Unsupported method.');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->append($value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function set(...$value)
    {
        $this->values = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getValuesAsArray()
    {
        return $this->ensureStrings(
            $this->preprocess(
                $this->ensureFlatArray($this->values),
                $this->name
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getValuesAsString()
    {
        return [] == ($values = $this->getValuesAsArray()) ?
            null :
            $this->escape(\implode(' ', \array_filter($values, '\strlen')));
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return null === ($values = $this->getValuesAsString()) ?
            $this->name :
            $this->name . '="' . $values . '"';
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
    public function isBoolean()
    {
        return [] == $this->getValuesAsArray();
    }

    /**
     * {@inheritdoc}
     */
    public function append(...$value)
    {
        $this->values[] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(...$value)
    {
        return $this->set(
            \array_diff(
                $this->ensureFlatArray($this->values),
                $this->ensureFlatArray($value)
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function replace($original, ...$replacement)
    {
        $count_start = \count($this->ensureFlatArray($this->values));
        $this->remove($original);

        if (\count($this->ensureFlatArray($this->values)) != $count_start) {
            $this->append($replacement);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function contains(...$substring)
    {
        $values = $this->ensureFlatArray($this->values);

        return !\in_array(
            false,
            \array_map(
                function ($substring_item) use ($values) {
                    return \in_array($substring_item, $values, true);
                },
                $this->ensureFlatArray($substring)
            ),
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setBoolean($boolean = true)
    {
        return true == $boolean ?
            $this->set() :
            $this->append('');
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        $this->name = '';
        $this->values = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function alter(callable ...$closures)
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
    public function serialize()
    {
        return \serialize([
            'name' => $this->name,
            'values' => $this->getValuesAsArray(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $unserialized = \unserialize($serialized);

        $this->name = $unserialized['name'];
        $this->values = $unserialized['values'];
    }

    /**
     * Escape a value.
     *
     * @param string $value
     *   The value to sanitize
     *
     * @return string|mixed
     *   The value sanitized.
     */
    protected function escape($value)
    {
        return null == $value ?
                $value:
                \htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
