<?php

declare(strict_types=1);

namespace drupol\htmltag\Attributes;

use ArrayAccess;
use ArrayIterator;
use Countable;
use drupol\htmltag\PreprocessableInterface;
use drupol\htmltag\RenderableInterface;
use drupol\htmltag\StringableInterface;
use IteratorAggregate;
use Serializable;
use Traversable;

/**
 * @template-extends IteratorAggregate<mixed>
 */
interface AttributesInterface extends
    ArrayAccess,
    Countable,
    IteratorAggregate,
    PreprocessableInterface,
    RenderableInterface,
    Serializable,
    StringableInterface
{
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
    public function append($key, ...$values): AttributesInterface;

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
    public function contains(string $key, ...$values): bool;

    /**
     * Delete an attribute.
     *
     * @param array|string ...$keys
     *   The name(s) of the attribute to delete.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function delete(string ...$keys): AttributesInterface;

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
    public function exists(string $key, ...$values): bool;

    /**
     * Get storage.
     *
     * @return ArrayIterator<mixed>
     *   The storage array
     */
    public function getStorage(): ArrayIterator;

    /**
     * Get the values as an array.
     *
     * @return array<string, mixed>
     *   The attributes values keyed by the attribute name
     */
    public function getValuesAsArray(): array;

    /**
     * Import attributes.
     *
     * @param array|Traversable $data
     *   The data to import
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function import($data): AttributesInterface;

    /**
     * Merge attributes.
     *
     * @param array<mixed> ...$dataset
     *   The data to merge.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function merge(array ...$dataset): AttributesInterface;

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
    public function remove(string $key, ...$values): AttributesInterface;

    /**
     * Replace a value with another.
     *
     * @param string $key
     *   The attributes's name
     * @param string $value
     *   The attribute's value
     * @param string ...$replacements
     *   The replacement values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function replace(string $key, string $value, string ...$replacements): AttributesInterface;

    /**
     * Set an attribute.
     *
     * @param string $key
     *   The attribute name
     * @param string|null ...$values
     *   The attribute values.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function set(string $key, ...$values): AttributesInterface;

    /**
     * Return the attributes without a specific attribute.
     *
     * @param string ...$keys
     *   The name(s) of the attribute to remove.
     *
     * @return \drupol\htmltag\Attributes\AttributesInterface
     *   The attributes
     */
    public function without(string ...$keys): AttributesInterface;
}
