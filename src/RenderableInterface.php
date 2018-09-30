<?php

namespace drupol\htmltag;

interface RenderableInterface
{
    /**
     * Render the object.
     *
     * @return string
     *   The object rendered in a string.
     */
    public function render();
}
