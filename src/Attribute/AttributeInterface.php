<?php

namespace drupol\htmltag\Attribute;

use drupol\htmltag\AlterableInterface;
use drupol\htmltag\RenderableInterface;
use drupol\htmltag\StringableInterface;

/**
 * Interface AttributeInterface.
 */
interface AttributeInterface extends
    \ArrayAccess,
    \Serializable,
    StringableInterface,
    RenderableInterface,
    AlterableInterface
{
    /**
     * Get the attribute name.
     *
     * @return string
     *   The attribute name.
     */
    public function getName();

    /**
     * Get the attribute value as an array.
     *
     * @return array
     *   The attribute value as an array.
     */
    public function getValuesAsArray();

    /**
     * Get the attribute value as a string.
     *
     * @return string|null
     *   The attribute value as a string.
     */
    public function getValuesAsString();

    /**
     * Check if the attribute is a loner attribute.
     *
     * @return bool
     *   True or False.
     */
    public function isBoolean();

    /**
     * Set the value.
     *
     * @param string|array|null ...$value
     *   The value.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function set(...$value);

    /**
     * Append a value to the attribute.
     *
     * @param string|mixed[]|null ...$value
     *   The value to append.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute.
     */
    public function append(...$value);

    /**
     * Remove a value from the attribute.
     *
     * @param string|array ...$value
     *   The value to remove.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute.
     */
    public function remove(...$value);

    /**
     * Replace a value of the attribute.
     *
     * @param string|mixed[] $original
     *   The original value.
     * @param string|mixed[] ...$replacement
     *   The replacement value.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute.
     */
    public function replace($original, ...$replacement);

    /**
     * Check if the attribute contains a string or a substring.
     *
     * @param string|mixed[] ...$substring
     *   The string to check.
     *
     * @return bool
     *   True or False.
     */
    public function contains(...$substring);

    /**
     * Set the attribute as a loner attribute.
     *
     * @param bool $boolean
     *   True or False.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute.
     */
    public function setBoolean($boolean = true);

    /**
     * Delete the current attribute.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute.
     */
    public function delete();

    /**
     * {@inheritdoc}
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     */
    public function alter(callable ...$closures);
}
