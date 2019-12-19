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
     * @param array<mixed> $values
     *   The values to preprocess.
     * @param array<mixed> $context
     *   The context.
     *
     * @return array<int, mixed>
     *   The values.
     */
    public function preprocess(array $values, array $context = []): array;
}
