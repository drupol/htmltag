<?php

namespace drupol\htmltag;

/**
 * Interface PreprocessableInterface.
 */
interface PreprocessableInterface
{
    /**
     * Preprocess the values of an object.
     *
     * @param array $values
     *   The values to preprocess.
     * @param array $context
     *   The context.
     *
     * @return array
     *   The values.
     */
    public function preprocess(array $values, array $context = []);
}
