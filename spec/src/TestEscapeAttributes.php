<?php

declare(strict_types = 1);

namespace drupol\htmltag\tests;

use drupol\htmltag\Attributes\Attributes;

class TestEscapeAttributes extends Attributes
{
    /**
     * @return null|string|void
     */
    public function publicEscape()
    {
        return $this->escape('nothing');
    }
}
