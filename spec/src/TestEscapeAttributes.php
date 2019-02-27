<?php

namespace drupol\htmltag\tests;

use drupol\htmltag\Attributes\AbstractAttributes;

class TestEscapeAttributes extends AbstractAttributes
{
    /**
     * @return null|string|void
     */
    public function publicEscape()
    {
        return $this->escape('nothing');
    }
}
