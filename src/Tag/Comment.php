<?php

namespace drupol\htmltag\Tag;

/**
 * Class Comment.
 */
final class Comment extends AbstractTag
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return \sprintf('<!--%s-->', $this->renderContent());
    }
}
