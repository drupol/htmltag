<?php

declare(strict_types = 1);

namespace drupol\htmltag\tests;

use drupol\atomium\tests\InvalidTagClass;
use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Tag\Tag;
use drupol\htmltag\Tag\TagFactory;

class TestTagFactory extends TagFactory
{
    public static $registry = [
        'attributes_factory' => AttributesFactory::class,
        'a' => Tag::class,
        'p' => InvalidTagClass::class,
    ];
}
