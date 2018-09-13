<?php

namespace drupol\htmltag\benchmarks;

use drupol\htmltag\HtmlTag;
use drupol\htmltag\Tag\TagFactory;

abstract class AbstractBench
{
    /**
     * @return array
     */
    public function getAttributes()
    {
        return [
            'bool-true' => true,
            'bool-false' => false,
            'bool-true-array' => array_fill(0, 3, true),
            'bool-false-array' => array_fill(0, 3, false),
            'integer' => 0,
            'integer-array' => range(0, 5),
            'integer-nested-array' => [0, [1, [2, [3, [4, [5]]]]]],
            'float' => M_PI,
            'float-array' => [M_1_PI, M_2_PI, M_PI, M_PI_2, M_PI_4],
            'float-nested-array' => [
                M_1_PI,
                [M_2_PI, [M_PI, [M_PI_2, [M_PI_4]]]]
            ],
            'string' => ' a b c d e f ',
            'string-array' => range('a', 'f'),
            'string-array-spaces' => ['a ', ' b ', ' c ', ' d ', ' e'],
            'string-nested-array' => ['a', ['b', ['c', ['d', ['e', ['f']]]]]],
        ];
    }
}
