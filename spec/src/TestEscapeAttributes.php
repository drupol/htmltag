<?php

namespace drupol\htmltag\tests;

use drupol\htmltag\Attributes\Attributes;

class TestEscapeAttributes extends Attributes
{
    /**
     * @return string|void|null
     */
    public function publicEscape()
    {
        return $this->escape('nothing');
    }
}
