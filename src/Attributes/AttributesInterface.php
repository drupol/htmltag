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
     * Import attributes.
     *
     * @param array|\Traversable $data
     *   The data to import.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function import($data);

    /**
     * Set an attribute.
     *
     * @param string $key
     *   The attribute name.
     * @param string|null ...$values
     *   The attribute values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function set($key, ...$values);

    /**
     * Append a value into an attribute.
     *
     * @param string $key
     *   The attribute's name.
     * @param string|array ...$values
     *   The attribute's values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function append($key, ...$values);

    /**
     * Remove a value from a specific attribute.
     *
     * @param string $key
     *   The attribute's name.
     * @param string|array ...$values
     *   The attribute's values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function remove($key, ...$values);

    /**
     * Delete an attribute.
     *
     * @param string|array ...$keys
     *   The name(s) of the attribute to delete.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function delete(...$keys);

    /**
     * Return the attributes without a specific attribute.
     *
     * @param string ...$keys
     *   The name(s) of the attribute to remove.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function without(...$keys);

    /**
     * Replace a value with another.
     *
     * @param string $key
     *   The attributes's name.
     * @param string $value
     *   The attribute's value.
     * @param array|string ...$replacements
     *   The replacement values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function replace($key, $value, ...$replacements);

    /**
     * Merge attributes.
     *
     * @param array ...$dataset
     *   The data to merge.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes.
     */
    public function merge(array ...$dataset);

    /**
     * Check if an attribute exists and if a value if provided check it as well.
     *
     * @param string $key
     *   Attribute name.
     * @param string|mixed ...$values
     *   The value to check if the attribute name exists.
     *
     * @return bool
     *   True if the attribute exists, false otherwise.
     */
    public function exists($key, ...$values);

    /**
     * Check if attribute contains a value.
     *
     * @param string $key
     *   Attribute name.
     * @param string|mixed[] ...$values
     *   Attribute values.
     *
     * @return bool
     *   Whereas an attribute contains a value.
     */
    public function contains($key, ...$values);

    /**
     * Get storage.
     *
     * @return \ArrayIterator
     *   The storage array.
     */
    public function getStorage();

    /**
     * {@inheritdoc}
     */
    public function __toString();

    /**
     * Get the values as an array.
     *
     * @return array
     *   The attributes values keyed by the attribute name.
     */
    public function getValuesAsArray();
}
