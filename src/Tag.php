<?php

namespace drupol\htmltag;

/**
 * Class Tag.
 */
class Tag
{
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
    public function __construct($name)
    {
        $this->tag = $name;
        $this->attributes = new Attributes();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return \drupol\htmltag\Tag
     */
    public static function __callStatic($name, $arguments)
    {
        return new static($name);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = sprintf('<%s%s', $this->tag, $this->attributes);

        if (null === $this->content) {
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
    private function renderContent()
    {
        return implode(
            '',
            array_filter(
                array_map(
                    function ($content_item) {
                        $output = '';

                        // Make sure we can 'stringify' the item.
                        if (!is_array($content_item) &&
                        ((!is_object($content_item) && settype($content_item, 'string') !== false) ||
                        (is_object($content_item) && method_exists($content_item, '__toString')))) {
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
     * Get the attributes as string or a specific attribute if $name is provided.
     *
     * @param string $name
     *   The name of the attribute.
     *
     * @param string $value
     *   The value.
     *
     * @return string|\drupol\htmltag\Attribute
     *   The attributes as string or a specific Attribute object.
     */
    public function attr($name = null, $value = null)
    {
        if (null === $name) {
            return (string) $this->attributes;
        }

        return $this->attributes[$name]->set($value);
    }

    /**
     * @param array $content
     *
     * @return string
     */
    public function content($content = [])
    {
        if (false === $content) {
            $this->content = null;
        } elseif ([] !== $content) {
            $this->content = $content;
        }

        return $this->renderContent();
    }
}
