<?php

namespace drupol\htmltag;

use drupol\DynamicObjects\DynamicObject;

/**
 * Class Attribute.
 */
class Attribute extends DynamicObject {
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
  public function __construct($name, $value = NULL) {
    $this->name = trim($name);
    $this->set($value);
    $this->extend(__DIR__.'/Core/Attribute.php');
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
  public function withName($name) {
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
  public function withValue($value) {
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
  public function getName() {
    return $this->name;
  }

  /**
   * Get the attribute value as a string.
   *
   * @return string
   *   The attribute value as a string.
   */
  public function getValueAsString() {
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
  public function getValueAsArray() {
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
  public function __toString() {
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
  public function isLoner() {
    if ([] === $this->getValueAsArray()) {
      $this->values = NULL;
    }

    return NULL === $this->values;
  }

  /**
   * Set the value.
   *
   * @param string|null $value
   *   The value.
   *
   * @return \drupol\htmltag\Attribute
   */
  public function set($value = NULL) {
    if (NULL !== $value) {
      $this->values = explode(' ', trim($value));
    }

    return $this;
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
  public function setLoner($loner = TRUE) {
    if (TRUE === $loner) {
      $this->values = NULL;
    }

    if (FALSE === $loner) {
      $this->values = array();
    }

    return $this;
  }
}
