<?php

namespace drupol\htmltag;

use drupol\htmltag\Tag\TagFactory;

/**
 * Class HtmlBuilder
 */
final class HtmlBuilder implements StringableInterface
{
    /**
     * The tag scope.
     *
     * @var \drupol\htmltag\Tag\TagInterface|null
     */
    private $scope;

    /**
     * The storage.
     *
     * @var \drupol\htmltag\Tag\TagInterface[]|string[]
     */
    private $storage;

    /**
     * {@inheritdoc}
     */
    public function __call($name, array $arguments = [])
    {
        if ('c' == $name) {
            if (!isset($arguments[0])) {
                return $this;
            }

            $comment = HtmlTag::tag('!--', [], $arguments[0]);

            if (null != $this->scope) {
                $this->scope->content($this->scope->getContentAsArray(), $comment);
            } else {
                $this->storage[] = $comment;
            }

            return $this;
        }

        if ('_' == $name) {
            $this->scope = null;

            return $this;
        }

        $tag = TagFactory::build($name, ...$arguments);

        if (null != $this->scope) {
            $this->scope->content($this->scope->getContentAsArray(), $tag);
        } else {
            $this->storage[] = $tag;
        }

        $this->scope = $tag;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $output = '';

        foreach ($this->storage as $item) {
            $output .= $item;
        }

        return $output;
    }
}
