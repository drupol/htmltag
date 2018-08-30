<?php

namespace drupol\htmltag;

/**
 * Class Attributes.
 */
class Attributes implements \ArrayAccess, \IteratorAggregate
{
    /**
     * Stores the attribute data.
     *
     * @var \drupol\htmltag\Attribute[]
     */
    private $storage = array();

    /**
     * {@inheritdoc}
     */
    public function __construct(array $attributes = array())
    {
        $this->setAttributes($attributes);
    }

    /**
     * Normalize a value.
     *
     * @param mixed $value
     *  The value to normalize.
     *
     * @return array
     *   The value normalized.
     */
    private function normalizeValue($value)
    {
        return $this->ensureFlatArray($value);
    }

    /**
     * Todo.
     *
     * @param mixed $value
     *   Todo.
     *
     * @return array
     *   The array, flattened.
     */
    private function ensureFlatArray($value)
    {
        $type = gettype($value);

        $return = array();

        switch ($type) {
            case 'string':
                $return = explode(
                    ' ',
                    $this->ensureString($value)
                );
                break;

            case 'array':
                $return = iterator_to_array(
                    new \RecursiveIteratorIterator(
                        new \RecursiveArrayIterator(
                            $value
                        )
                    ),
                    false
                );
                break;

            case 'double':
            case 'integer':
                $return = array($value);
                break;
            case 'object':
            case 'boolean':
            case 'resource':
            case 'NULL':
        }

        return $return;
    }

    /**
     * Todo.
     *
     * @param mixed $value
     *   Todo.
     *
     * @return null|string
     *   Null or a string.
     */
    private function ensureString($value)
    {
        $type = gettype($value);

        $return = '';

        switch ($type) {
            case 'string':
                $return = $value;
                break;

            case 'array':
                $return = implode(
                    ' ',
                    $this->ensureFlatArray($value)
                );
                break;

            case 'double':
            case 'integer':
                 $return = (string) $value;
                break;
            case 'object':
            case 'boolean':
            case 'resource':
            case 'NULL':
        }

        return $return;
    }

    /**
     * Set attributes.
     *
     * @param array|Attributes $attributes
     *   The attributes.
     *
     * @return $this
     */
    public function setAttributes($attributes = array())
    {
        foreach ($attributes as $name => $value) {
            $this->storage[$name] = new Attribute(
                $name,
                $this->ensureString($value)
            );
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function &offsetGet($name)
    {
        if (!isset($this->storage[$name])) {
            $attribute = new Attribute(
                $name
            );
        } else {
            $attribute = $this->storage[$name];
        }

        $this->storage[$name] = $attribute->withName($name);

        return $this->storage[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($name, $value = null)
    {
        $this->storage[$name] = new Attribute(
            $name,
            $this->ensureString($value)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($name)
    {
        unset($this->storage[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($name)
    {
        return isset($this->storage[$name]);
    }

    /**
     * Sets values for an attribute key.
     *
     * @param string $attribute
     *   Name of the attribute.
     * @param string|array|bool $value
     *   Value(s) to set for the given attribute key.
     *
     * @return $this
     */
    public function setAttribute($attribute, $value = false)
    {
        $this->offsetSet($attribute, $value);

        return $this;
    }

    /**
     * Append a value into an attribute.
     *
     * @param string $key
     *   The attribute's name.
     * @param string|array|bool $value
     *   The attribute's value.
     *
     * @return $this
     */
    public function append($key, $value = null)
    {
        if (!isset($this->storage[$key])) {
            $attribute = new Attribute(
                $key,
                $this->ensureString($value)
            );
        } else {
            $attribute = $this->storage[$key];
        }

        $value = $this->normalizeValue($value);

        foreach ($value as $value_item) {
            $attribute->append($value_item);
        }

        $this->storage[$key] = $attribute;

        return $this;
    }

    /**
     * Remove a value from a specific attribute.
     *
     * @param string $key
     *   The attribute's name.
     * @param string|array|bool $value
     *   The attribute's value.
     *
     * @return $this
     */
    public function remove($key, $value = false)
    {
        if (!isset($this->storage[$key])) {
            return $this;
        }

        $value = $this->normalizeValue($value);

        $attribute = $this->storage[$key];

        foreach ($value as $value_item) {
            $attribute->remove($value_item);
        }

        $this->storage[$key] = $attribute;

        return $this;
    }

    /**
     * Delete an attribute.
     *
     * @param string|array $name
     *   The name of the attribute key to delete.
     *
     * @return $this
     */
    public function delete($name = array())
    {
        $name = $this->normalizeValue($name);

        foreach ($name as $attribute_name) {
            unset($this->storage[$attribute_name]);
        }

        return $this;
    }

    /**
     * Return the attributes.
     *
     * @param string $key
     *   The attributes's name.
     * @param array|string $value
     *   The attribute's value.
     *
     * @return $this
     */
    public function without($key, $value)
    {
        $attributes = clone $this;

        return $attributes->remove($key, $value);
    }

    /**
     * Replace a value with another.
     *
     * @param string $key
     *   The attributes's name.
     * @param string $value
     *   The attribute's value.
     * @param array|string $replacement
     *   The replacement value.
     *
     * @return $this
     */
    public function replace($key, $value, $replacement)
    {
        if (!isset($this->storage[$key])) {
            $attribute = new Attribute(
                $key,
                $this->ensureString($value)
            );
        } else {
            $attribute = $this->storage[$key];
        }

        $replacement = $this->normalizeValue($replacement);

        $attribute->remove($value);
        foreach ($replacement as $replacement_value) {
            $attribute->append($replacement_value);
        }

        $this->storage[$key] = $attribute;

        return $this;
    }

    /**
     * Merge attributes.
     *
     * @param array $data
     *   The data to merge.
     *
     * @return $this
     */
    public function merge(array $data = array())
    {
        foreach ($data as $key => $value) {
            if (!isset($this->storage[$key])) {
                $attribute = new Attribute($key);
            } else {
                $attribute = $this->storage[$key];
            }

            $attribute->merge(
                $this->normalizeValue($value)
            );

            $this->storage[$key] = $attribute;
        }

        return $this;
    }

    /**
     * Check if an attribute exists and if a value if provided check it as well.
     *
     * @param string $key
     *   Attribute name.
     * @param string $value
     *   Todo.
     *
     * @return bool
     *   Whereas an attribute exists.
     */
    public function exists($key, $value = null)
    {
        if (isset($this->storage[$key])) {
            $attribute = $this->storage[$key];
        } else {
            return false;
        }

        if (null !== $value) {
            return $attribute->contains($value);
        }

        return true;
    }

    /**
     * Check if attribute contains a value.
     *
     * @param string $key
     *   Attribute name.
     * @param string|bool $value
     *   Attribute value.
     *
     * @return bool
     *   Whereas an attribute contains a value.
     */
    public function contains($key, $value = false)
    {
        if (!isset($this->storage[$key])) {
            return false;
        }

        $attribute = $this->storage[$key];

        return $attribute->contains($value);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $attributes = $this->storage;

        // If empty, just return an empty string.
        if (empty($attributes)) {
            return '';
        }

        $result = implode(' ', $this->prepareValues());

        return $result ? ' ' . $result : '';
    }

    /**
     * Returns all storage elements as an array.
     *
     * @return \drupol\htmltag\Attribute[]
     *   An associative array of attributes.
     */
    private function prepareValues()
    {
        $attributes = $this->storage;

        // If empty, just return an empty array.
        if (empty($attributes)) {
            return array();
        }

        // Sort the attributes.
        ksort($attributes);

        $result = [];

        foreach ($attributes as $attribute_name => $attribute) {
            switch ($attribute_name) {
                case 'class':
                    $classes = $attribute->getValueAsArray();
                    asort($classes);
                    $result[$attribute->getName()] = $attribute
                    ->withValue(
                        implode(' ', $classes)
                    );
                    break;

                case 'placeholder':
                    $result[$attribute->getName()] = $attribute
                    ->withValue(
                        strip_tags($attribute->getValueAsString())
                    );
                    break;

                default:
                    $result[$attribute->getName()] = $attribute;
            }
        }

        return $result;
    }

    /**
     * Returns all storage elements as an array.
     *
     * @return array
     *   An associative array of attributes.
     */
    public function toArray()
    {
        $attributes = $this->storage;

        // If empty, just return an empty array.
        if (empty($attributes)) {
            return array();
        }

        $result = [];

        foreach ($this->prepareValues() as $attribute) {
            $result[$attribute->getName()] = $attribute->getValueAsArray();
        }

        return $result;
    }

    /**
     * Get storage.
     *
     * @return \drupol\htmltag\Attribute[]
     *   Todo.
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }
}
