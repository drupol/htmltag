<?php

namespace drupol\htmltag;

/**
 * Interface EscapableInterface.
 */
interface EscapableInterface
{
    /**
     * Escape a value.
     *
     * @param mixed|string|StringableInterface|null $value
     *   The value to escape.
     *
     * @return string|StringableInterface|null
     *   The value.
     */
    public function escape($value);
}
