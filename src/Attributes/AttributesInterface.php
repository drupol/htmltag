<?php

namespace drupol\htmltag\Attributes;

use drupol\htmltag\RenderableInterface;
use drupol\htmltag\StringableInterface;

/**
 * Interface AttributesInterface.
 */
interface AttributesInterface extends
    \ArrayAccess,
    \IteratorAggregate,
    \Countable,
    \Serializable,
    RenderableInterface,
    StringableInterface
{
    /**
     * {@inheritdoc}
     */
    public function __toString();

    /**
     * Append a value into an attribute.
     *
     * @param string $key
     *   The attribute's name
     * @param array|string ...$values
     *   The attribute's values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function append($key, ...$values);

    /**
     * Check if attribute contains a value.
     *
     * @param string $key
     *   Attribute name
     * @param mixed[]|string ...$values
     *   Attribute values.
     *
     * @return bool
     *   Whereas an attribute contains a value
     */
    public function contains($key, ...$values);

    /**
     * Delete an attribute.
     *
     * @param array|string ...$keys
     *   The name(s) of the attribute to delete.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function delete(...$keys);

    /**
     * Check if an attribute exists and if a value if provided check it as well.
     *
     * @param string $key
     *   Attribute name
     * @param mixed|string ...$values
     *   The value to check if the attribute name exists.
     *
     * @return bool
     *   True if the attribute exists, false otherwise
     */
    public function exists($key, ...$values);

    /**
     * Get storage.
     *
     * @return \ArrayIterator
     *   The storage array
     */
    public function getStorage();

    /**
     * Get the values as an array.
     *
     * @return array
     *   The attributes values keyed by the attribute name
     */
    public function getValuesAsArray();

    /**
     * Import attributes.
     *
     * @param array|\Traversable $data
     *   The data to import
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function import($data);

    /**
     * Merge attributes.
     *
     * @param array ...$dataset
     *   The data to merge.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function merge(array ...$dataset);

    /**
     * Remove a value from a specific attribute.
     *
     * @param string $key
     *   The attribute's name
     * @param array|string ...$values
     *   The attribute's values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function remove($key, ...$values);

    /**
     * Replace a value with another.
     *
     * @param string $key
     *   The attributes's name
     * @param string $value
     *   The attribute's value
     * @param array|string ...$replacements
     *   The replacement values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function replace($key, $value, ...$replacements);

    /**
     * Set an attribute.
     *
     * @param string $key
     *   The attribute name
     * @param null|string ...$values
     *   The attribute values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function set($key, ...$values);

    /**
     * Return the attributes without a specific attribute.
     *
     * @param string ...$keys
     *   The name(s) of the attribute to remove.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function without(...$keys);
}
