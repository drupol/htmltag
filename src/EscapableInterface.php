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
     * @param null|mixed|string|StringableInterface $value
     *   The value to escape.
     *
     * @return null|string|StringableInterface
     *   The value.
     */
    public function escape($value);
}
