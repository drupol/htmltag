<?php

namespace drupol\htmltag\tests;

use drupol\atomium\tests\InvalidTagClass;
use drupol\htmltag\Tag\TagFactory;

class TestTagFactory extends TagFactory
{
    public static $registry = [
        '*' => InvalidTagClass::class,
    ];
}
