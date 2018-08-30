<?php

namespace drupol\htmltag;

/**
 * Class Attribute.
 */
class Attribute
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
     * @var array|null
     */
    private $values;

    /**
     * Attribute constructor.
     *
     * @param string $name
     *   The attribute name.
     * @param string $value
     *   The attribute value.
     */
    public function __construct($name, $value = null)
    {
        $this->name = trim($name);
        $this->set($value);
    }

    /**
     * Create a copy of the current attribute with a specific name.
     *
     * @param string $name
     *   The attribute name.
     *
     * @return \drupol\htmltag\Attribute
     *   The attribute.
     */
    public function withName($name)
    {
        $clone = clone $this;

        $clone->name = trim($name);

        return $clone;
    }

    /**
     * Create a copy of the current attribute with specific value.
     *
     * @param string $value
     *   The attribute value.
     *
     * @return \drupol\htmltag\Attribute
     *   The attribute.
     */
    public function withValue($value)
    {
        $clone = clone $this;

        $clone->values = explode(' ', trim($value));

        return $clone;
    }

    /**
     * Get the attribute name.
     *
     * @return string
     *   The attribute name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the attribute value as a string.
     *
     * @return string
     *   The attribute value as a string.
     */
    public function getValueAsString()
    {
        return implode(
            ' ',
            $this->getValueAsArray()
        );
    }

    /**
     * Get the attribute value as an array.
     *
     * @return array
     *   The attribute value as an array.
     */
    public function getValueAsArray()
    {
        return array_values(
            array_filter(
                array_unique(
                    (array) $this->values
                )
            )
        );
    }

    /**
     * Convert the object in a string.
     *
     * @return string
     *   The attribute as a string.
     */
    public function __toString()
    {
        $output = $this->name;

        if (!$this->isLoner()) {
            $output .= '="' . trim($this->getValueAsString()) . '"';
        }

        return $output;
    }

    /**
     * Check if the attribute is a loner attribute.
     *
     * @return bool
     *   True or False.
     */
    public function isLoner()
    {
        if ([] === $this->getValueAsArray()) {
            $this->values = null;
        }

        return null === $this->values;
    }

    /**
     * Set the value.
     *
     * @param string|null $value
     *   The value.
     *
     * @return \drupol\htmltag\Attribute
     */
    public function set($value = null)
    {
        if (null !== $value) {
            $this->values = explode(' ', trim($value));
        }

        return $this;
    }

    /**
     * Append a value to the attribute.
     *
     * @param string $value
     *   The value to append.
     *
     * @return $this
     *   The attribute.
     */
    public function append($value)
    {
        $this->values = array_merge(
            (array) $this->values,
            explode(
                ' ',
                trim($value)
            )
        );

        return $this;
    }

    /**
     * Merge data into the attribute value.
     *
     * @param array $values
     *   The values to merge.
     *
     * @return $this
     *   The attribute.
     */
    public function merge(array $values)
    {
        $this->values = array_merge(
            (array) $this->values,
            $values
        );

        return $this;
    }

    /**
     * Remove a value from the attribute.
     *
     * @param string $value
     *   The value to remove.
     *
     * @return $this
     *   The attribute.
     */
    public function remove($value)
    {
        $this->values = array_filter(
            (array) $this->values,
            function ($value_item) use ($value) {
                return $value_item !== $value;
            }
        );

        return $this;
    }

    /**
     * Replace a value of the attribute.
     *
     * @param string $original
     *   The original value.
     * @param string $replacement
     *   The replacement value.
     *
     * @return $this
     *   The attribute.
     */
    public function replace($original, $replacement)
    {
        $this->values = array_map(
            function (&$value_item) use ($original, $replacement) {
                if ($value_item === $original) {
                    $value_item = $replacement;
                }

                return $value_item;
            },
            (array) $this->values
        );

        return $this;
    }

    /**
     * Check if the attribute contains a string or a substring.
     *
     * @param string $substring
     *   The string to check.
     *
     * @return bool
     *   True or False.
     */
    public function contains($substring)
    {
        foreach ((array) $this->values as $value_item) {
            if (false !== strpos($value_item, $substring)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set the attribute as a loner attribute.
     *
     * @param bool $loner
     *   True or False.
     *
     * @return $this
     *   The attribute.
     */
    public function setLoner($loner = true)
    {
        if (true === $loner) {
            $this->values = null;
        }

        if (false === $loner) {
            $this->values = array();
        }

        return $this;
    }

    /**
     * Delete the current attribute.
     *
     * @return $this
     *   The attribute.
     */
    public function delete()
    {
        $this->name = '';
        $this->values = null;

        return $this;
    }
}
