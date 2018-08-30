<?php

namespace drupol\htmltag;

/**
 * Class Attributes.
 */
class Attributes implements \ArrayAccess, \IteratorAggregate {
  /**
   * Stores the attribute data.
   *
   * @var \drupol\htmltag\Attribute[]
   */
  private $storage = array();

  /**
   * {@inheritdoc}
   */
  public function __construct(array $attributes = array()) {
    $this->setAttributes($attributes);
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
  private function ensureFlatArray($value) {
    $type = gettype($value);

    $return = NULL;
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
          FALSE
        );
        break;

      case 'object':
      case 'boolean':
      case 'double':
      case 'integer':
        $return = array($value);
        break;

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
  private function ensureString($value) {
    $type = gettype($value);

    $return = NULL;

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

      case 'object':
      case 'boolean':
      case 'double':
      case 'integer':
        $return = (string) $value;
        break;

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
  public function setAttributes($attributes = array()) {
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
  public function &offsetGet($name) {
    if (!isset($this->storage[$name])) {
      $attribute = new Attribute(
        $name
      );
    }
    else {
      $attribute = $this->storage[$name];
    }

    $this->storage[$name] = $attribute->withName($name);

    return $this->storage[$name];
  }

  /**
   * {@inheritdoc}
   */
  public function offsetSet($name, $value = NULL) {
    $this->storage[$name] = new Attribute(
      $name,
      $this->ensureString($value)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function offsetUnset($name) {
    unset($this->storage[$name]);
  }

  /**
   * {@inheritdoc}
   */
  public function offsetExists($name) {
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
  public function setAttribute($attribute, $value = FALSE) {
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
  public function append($key, $value = NULL) {
    if (!isset($this->storage[$key])) {
      $attribute = new Attribute(
        $key,
        $this->ensureString($value)
      );
    }
    else {
      $attribute = $this->storage[$key];
    }

    $type = gettype($value);

    switch ($type) {
      case 'string':
        $attribute->append($value);
        break;

      case 'array':
        foreach ($this->ensureFlatArray($value) as $value_item) {
          $attribute->append($value_item);
        }

        break;

      case 'object':
      case 'boolean':
      case 'integer':
      case 'double':
      case 'resource':
      case 'NULL':
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
  public function remove($key, $value = FALSE) {
    if (!isset($this->storage[$key])) {
      return $this;
    }

    $attribute = $this->storage[$key];

    $type = gettype($value);

    switch ($type) {
      case 'string':
        $attribute->remove($value);
        break;

      case 'array':
        $value = $this->ensureFlatArray($value);

        foreach ($value as $value_item) {
          $attribute->remove($value_item);
        }

        break;

      case 'object':
      case 'boolean':
      case 'integer':
      case 'double':
      case 'resource':
      case 'NULL':
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
  public function delete($name = array()) {
    $type = gettype($name);

    switch ($type) {
      case 'string':
        $name = array($name);
        break;

      case 'array':
        $name = $this->ensureFlatArray($name);
        break;

      case 'object':
      case 'boolean':
      case 'integer':
      case 'double':
      case 'resource':
      case 'NULL':
    }

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
  public function without($key, $value) {
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
  public function replace($key, $value, $replacement) {
    if (!isset($this->storage[$key])) {
      $attribute = new Attribute(
        $key,
        $this->ensureString($value)
      );
    }
    else {
      $attribute = $this->storage[$key];
    }

    $type = gettype($replacement);

    switch ($type) {
      case 'string':
        $replacement = array($replacement);
        break;

      case 'array':
        $replacement = $this->ensureFlatArray($replacement);
        break;

      case 'object':
      case 'boolean':
      case 'integer':
      case 'double':
      case 'resource':
      case 'NULL':
    }

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
  public function merge(array $data = array()) {
    foreach ($data as $key => $value) {
      if (!isset($this->storage[$key])) {
        $attribute = new Attribute($key);
      }
      else {
        $attribute = $this->storage[$key];
      }

      $attribute->merge(
        (array) $value
      );

      $this->storage[$key] = $attribute;
    }

    return $this;
  }

  /**
   * Check if attribute exists.
   *
   * @param string $key
   *   Attribute name.
   * @param string $value
   *   Todo.
   *
   * @return bool
   *   Whereas an attribute exists.
   */
  public function exists($key, $value = NULL) {
    if (isset($this->storage[$key])) {
      $attribute = $this->storage[$key];
    }
    else {
      return FALSE;
    }

    if (NULL !== $value) {
      return $attribute->contains($value);
    }

    return TRUE;
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
  public function contains($key, $value = FALSE) {
    if (!isset($this->storage[$key])) {
      return FALSE;
    }

    $attribute = $this->storage[$key];

    return $attribute->contains($value);
  }

  /**
   * {@inheritdoc}
   */
  public function __toString() {
    $attributes = $this->storage;

    // If empty, just return an empty string.
    if (empty($attributes)) {
      return '';
    }

    // Sort the attributes.
    ksort($attributes);

    $result = [];

    foreach ($attributes as $attribute_name => &$attribute) {
      switch ($attribute_name) {
        case 'class':
          $classes = $this->ensureFlatArray($attribute->getValueAsArray());
          asort($classes);
          $result[] = (string) $attribute
            ->withValue(
              implode(' ', $classes)
            );
          break;

        case 'placeholder':
          $result[] = (string) $attribute
            ->withValue(
              strip_tags($attribute->getValueAsString())
            );
          break;

        default:
          $result[] = (string) $attribute;
      }
    }

    return $attributes ? ' ' . implode(' ', array_filter($result, 'strlen')) : '';
  }

  /**
   * Returns all storage elements as an array.
   *
   * @return array
   *   An associative array of attributes.
   */
  public function toArray() {
    $attributes = $this->storage;

    // If empty, just return an empty array.
    if (empty($attributes)) {
      return array();
    }

    // Sort the attributes.
    ksort($attributes);

    $result = [];

    foreach ($attributes as $attribute_name => &$attribute) {
      switch ($attribute_name) {
        case 'class':
          $classes = $attribute->getValueAsArray();
          asort($classes);
          $result[$attribute->getName()] = $attribute
            ->withValue(
              implode(' ', $classes)
            )->getValueAsArray();
          break;

        case 'placeholder':
          $result[$attribute->getName()] = $attribute
            ->withValue(
              strip_tags($attribute->getValueAsString())
            )->getValueAsArray();
          break;

        default:
          $result[$attribute->getName()] = $attribute->getValueAsArray();
      }
    }

    return $result;
  }

  /**
   * Get storage.
   *
   * @return \drupol\htmltag\Attribute[]
   *   Todo.
   */
  public function getStorage() {
    return $this->storage;
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return new \ArrayIterator($this->toArray());
  }

}
