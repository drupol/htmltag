<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\AbstractBaseHtmlTagObject;
use drupol\htmltag\Attributes\AttributesInterface;
use drupol\htmltag\StringableInterface;

/**
 * Class AbstractTag.
 */
abstract class AbstractTag extends AbstractBaseHtmlTagObject implements TagInterface
{
    /**
     * The tag attributes.
     *
     * @var \drupol\htmltag\Attributes\AttributesInterface
     */
    private $attributes;

    /**
     * The tag content.
     *
     * @var null|mixed[]
     */
    private $content;
    /**
     * The tag name.
     *
     * @var string
     */
    private $tag;

    /**
     * Tag constructor.
     *
     * @param \drupol\htmltag\Attributes\AttributesInterface $attributes
     *   The attributes object
     * @param string $name
     *   The tag name
     * @param mixed $content
     *   The content
     */
    public function __construct(AttributesInterface $attributes, $name, $content = null)
    {
        $this->tag = $name;
        $this->attributes = $attributes;
        $this->content($content);
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return \drupol\htmltag\Tag\TagInterface
     */
    public static function __callStatic($name, array $arguments = [])
    {
        return new static($arguments[0], $name);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * {@inheritdoc}
     */
    public function alter(callable ...$closures)
    {
        foreach ($closures as $closure) {
            $this->content = $closure(
                $this->ensureFlatArray((array) $this->content)
            );
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function attr($name = null, ...$value)
    {
        if (null === $name) {
            return $this->attributes->render();
        }

        if ([] === $value) {
            return $this->attributes[$name];
        }

        return $this->attributes[$name]->set($value);
    }

    /**
     * {@inheritdoc}
     */
    public function content(...$data)
    {
        if ([] !== $data) {
            if (null === \reset($data)) {
                $data = null;
            }

            $this->content = $data;
        }

        return $this->renderContent();
    }

    /**
     * @return array|\drupol\htmltag\Attribute\AttributeInterface[]
     */
    public function getContentAsArray()
    {
        return $this->preprocess(
            $this->ensureFlatArray((array) $this->content)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return null === ($content = $this->renderContent()) ?
            \sprintf('<%s%s/>', $this->tag, $this->attributes->render()) :
            \sprintf('<%s%s>%s</%s>', $this->tag, $this->attributes->render(), $content, $this->tag);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return \serialize([
            'tag' => $this->tag,
            'attributes' => $this->attributes->getValuesAsArray(),
            'content' => $this->renderContent(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $unserialize = \unserialize($serialized);

        $this->tag = $unserialize['tag'];
        $this->attributes = $this->attributes->import($unserialize['attributes']);
        $this->content = $unserialize['content'];
    }

    /**
     * {@inheritdoc}
     */
    protected function escape($value)
    {
        $return = $this->ensureString($value);

        if ($value instanceof StringableInterface) {
            return $return;
        }

        return null === $return ?
            $return :
            \htmlentities($return);
    }

    /**
     * Render the tag content.
     *
     * @return null|string
     */
    protected function renderContent()
    {
        return ($items = \array_map([$this, 'escape'], $this->getContentAsArray())) === [] ?
            null :
            \implode('', $items);
    }
}
