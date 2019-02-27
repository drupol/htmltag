<?php

namespace drupol\htmltag\tests;

use drupol\atomium\tests\InvalidAttributeClass;
use drupol\atomium\tests\ValidAttributeClass;
use drupol\htmltag\Attribute\AttributeFactory;

class TestAttributeFactory extends AttributeFactory
{
    public static $registry = [
        'class' => ValidAttributeClass::class,
        '*' => InvalidAttributeClass::class,
    ];
}
