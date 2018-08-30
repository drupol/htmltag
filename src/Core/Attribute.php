<?php

namespace drupol\htmltag\Core;

use drupol\htmltag\Attribute;

return function (Attribute $Attribute) {
  /**
   * Append value to the attribute.
   *
   * @param string $value
   *   The values to append.
   *
   * @return $this
   *   The attribute.
   */
  $Attribute::addDynamicMethod('append', function($value) {
    $this->values =
      array_merge(
        (array) $this->values,
        explode(
          ' ',
          trim($value)
        )
      );

    return $this;
  });

  /**
   * Merge data into the attribute value.
   *
   * @param array $values
   *   The values to merge.
   *
   * @return $this
   *   The attribute.
   */
  $Attribute::addDynamicMethod(
    'merge',
    function(array $values) {
      $this->values = array_merge(
        (array) $this->values,
        $values
      );

      return $this;
    }
  );

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
  $Attribute::addDynamicMethod(
    'replace',
    function ($original, $replacement) {
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
  );

  /**
   * Remove a value from the attribute.
   *
   * @param string $value
   *   The value to remove.
   *
   * @return $this
   *   The attribute.
   */
  $Attribute::addDynamicMethod(
    'remove',
    function ($value) {
      $this->values = array_filter(
        (array) $this->values,
        function ($value_item) use ($value) {
          return $value_item !== $value;
        }
      );

      return $this;
    }
  );

  /**
   * Check if the attribute contains a string or a substring.
   *
   * @param string $substring
   *   The string to check.
   *
   * @return bool
   *   True or False.
   */
  $Attribute::addDynamicMethod(
    'contains',
    function ($substring) {
      foreach ((array) $this->values as $value_item) {
        if (FALSE !== strpos($value_item, $substring)) {
          return TRUE;
        }
      }

      return FALSE;
    }
  );

  /**
   * Delete the current attribute.
   *
   * @return $this
   *   The attribute.
   */
  $Attribute::addDynamicMethod('delete', function() {
    $this->name = '';
    $this->values = NULL;

    return $this;
  });
};
