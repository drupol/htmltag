<?php

namespace drupol\htmltag;

/**
 * Interface AlterableInterface
 */
interface AlterableInterface
{
    /**
     * Alter the values of an object.
     *
     * @param callable ...$closures
     *   The closure(s).
     *
     * @return object
     *   The object.
     */
    public function alter(callable ...$closures);
}
