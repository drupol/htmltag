<?php

namespace drupol\htmltag;

use drupol\DynamicObjects\DynamicObject;

/**
 * Class Tag.
 */
class Tag extends DynamicObject {
  /**
   * The tag name.
   *
   * @var string
   */
  private $tag;

  /**
   * The tag attributes.
   *
   * @var \drupol\htmltag\Attributes
   */
  private $attributes;

  /**
   * The tag content.
   *
   * @var mixed[]
   */
  private $content;

  /**
   * Tag constructor.
   *
   * @param string $name
   *   The tag name.
   */
  private function __construct($name) {
    $this->tag = $name;
    $this->attributes = new Attributes();
  }

  /**
   * @param $name
   * @param $arguments
   *
   * @return \drupol\htmltag\Tag
   */
  public static function __callStatic($name, array $arguments = array()) {
    return new static($name);
  }

  /**
   * Render the tag.
   *
   * @return string
   */
  public function __toString() {
    $output = sprintf('<%s%s', $this->tag, $this->attributes);

    if (NULL === $this->content) {
      $output .= '/>';
    } else {
      $output .= sprintf('>%s</%s>', $this->renderContent(), $this->tag);
    }

    return $output;
  }

  /**
   * Render the tag content.
   *
   * @return string
   */
  private function renderContent() {
    return implode(
      '',
      array_filter(
        array_map(
          function ($content_item) {
            $output = '';

            // Make sure we can 'stringify' the item.
            if ( !is_array( $content_item ) &&
              ( ( !is_object( $content_item ) && settype( $content_item, 'string' ) !== false ) ||
                ( is_object( $content_item ) && method_exists( $content_item, '__toString' ) ) )) {
              $output = (string) $content_item;
            }

            return $output;
          },
          (array) $this->content
        ),
        'strlen'
      )
    );
  }

  /**
   * @param null $name
   *
   * @return string|\drupol\htmltag\Attribute
   */
  public function attr($name = NULL) {
    return $name ?
      $this->attributes[$name] :
      (string) $this->attributes;
  }

  /**
   * @param array $content
   *
   * @return string
   */
  public function content($content = []) {
    if (FALSE === $content) {
      $this->content = NULL;
    } else if ([] !== $content) {
      $this->content = $content;
    }

    return $this->renderContent();
  }

}
