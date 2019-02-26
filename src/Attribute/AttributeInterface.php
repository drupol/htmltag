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
     * {@inheritdoc}
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     */
    public function alter(callable ...$closures);

    /**
     * Append a value to the attribute.
     *
     * @param null|mixed[]|string ...$value
     *   The value to append.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function append(...$value);

    /**
     * Check if the attribute contains a string or a substring.
     *
     * @param mixed[]|string ...$substring
     *   The string to check.
     *
     * @return bool
     *   True or False
     */
    public function contains(...$substring);

    /**
     * Delete the current attribute.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function delete();

    /**
     * Get the attribute name.
     *
     * @return string
     *   The attribute name
     */
    public function getName();

    /**
     * Get the attribute value as an array.
     *
     * @return array
     *   The attribute value as an array
     */
    public function getValuesAsArray();

    /**
     * Get the attribute value as a string.
     *
     * @return null|string
     *   The attribute value as a string
     */
    public function getValuesAsString();

    /**
     * Check if the attribute is a loner attribute.
     *
     * @return bool
     *   True or False
     */
    public function isBoolean();

    /**
     * Remove a value from the attribute.
     *
     * @param array|string ...$value
     *   The value to remove.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function remove(...$value);

    /**
     * Replace a value of the attribute.
     *
     * @param mixed[]|string $original
     *   The original value
     * @param mixed[]|string ...$replacement
     *   The replacement value.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function replace($original, ...$replacement);

    /**
     * Set the value.
     *
     * @param null|array|string ...$value
     *   The value.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function set(...$value);

    /**
     * Set the attribute as a loner attribute.
     *
     * @param bool $boolean
     *   True or False
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface
     *   The attribute
     */
    public function setBoolean($boolean = true);
}
