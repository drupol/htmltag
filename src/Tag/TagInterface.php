<?php

declare(strict_types=1);

namespace drupol\htmltag\Tag;

use drupol\htmltag\AlterableInterface;
use drupol\htmltag\EscapableInterface;
use drupol\htmltag\PreprocessableInterface;
use drupol\htmltag\RenderableInterface;
use drupol\htmltag\StringableInterface;
use Serializable;

interface TagInterface extends
    AlterableInterface,
    EscapableInterface,
    PreprocessableInterface,
    RenderableInterface,
    Serializable,
    StringableInterface
{
    /**
     * Get the attributes as string or a specific attribute if $name is provided.
     *
     * @param string $name
     *   The name of the attribute
     * @param mixed ...$value
     *   The value.
     *
     * @return \drupol\htmltag\Attribute\AttributeInterface|string
     *   The attributes as string or a specific Attribute object
     */
    public function attr(?string $name = null, ...$value);

    /**
     * Set or get the content.
     *
     * @param mixed ...$data
     *   The content.
     *
     * @return string|null
     *   The content
     */
    public function content(...$data): ?string;

    /**
     * Get the content.
     *
     * @return array<int, string>
     *   The content as an array
     */
    public function getContentAsArray(): array;
}
