<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;

/**
 * Class Comment.
 */
class Comment extends Tag
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return \sprintf('<!--%s-->', $this->renderContent());
    }
}
