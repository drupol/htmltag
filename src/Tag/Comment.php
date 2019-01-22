<?php

declare(strict_types = 1);

namespace drupol\htmltag\Tag;

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
