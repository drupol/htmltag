<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Attributes\AttributesInterface;

/**
 * Class Comment.
 */
class Comment extends Tag
{
    /**
     * Comment constructor.
     *
     * @param mixed $content
     *   The comment content.
     */
    public function __construct(
        $content = null
    ) {
        $attributes = AttributesFactory::build();

        parent::__construct($attributes, 'comment', $content);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return \sprintf('<!--%s-->', $this->renderContent());
    }
}
