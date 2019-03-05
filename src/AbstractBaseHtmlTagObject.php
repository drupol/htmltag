<?php

namespace drupol\htmltag;

/**
 * Class AbstractBaseHtmlTagObject.
 *
 * This class is the base class of other HTMLTag objects.
 * It contains simple methods that are needed everywhere.
 * We could have used a Trait instead, but I don't like working with traits.
 */
abstract class AbstractBaseHtmlTagObject
{
    /**
     * Transform a multidimensional array into a flat array.
     *
     * This method will flatten an array containing arrays.
     * Keys will be lost during the flattening.
     * We could use a iterator_to_array() with a custom RecursiveArrayIterator.
     * But it seems to be even slower.
     *
     * @see http://php.net/manual/en/class.recursivearrayiterator.php#106519
     *
     * @param mixed[] $data
     *   The input array
     *
     * @return mixed[]
     *   A simple array
     */
    protected function ensureFlatArray(array $data)
    {
        $flat = [];

        while (!empty($data)) {
            $value = \array_shift($data);

            if (\is_array($value)) {
                $data = \array_merge($value, $data);

                continue;
            }

            $flat[] = $value;
        }

        return $flat;
    }

    /**
     * Convert a value into a string when it's possible.
     *
     * Ensure that the value gets converted into a string when it is possible.
     * When it's not possible, the "null" value is returned instead.
     *
     * @param mixed $data
     *   The input value
     *
     * @return null|string
     *   The value converted as a string or null
     */
    protected function ensureString($data)
    {
        $return = null;

        switch (\gettype($data)) {
            case 'string':
                $return = $data;

                break;

            case 'integer':
            case 'double':
                $return = (string) $data;

                break;

            case 'object':
                if (\method_exists($data, '__toString')) {
                    $return = $data->__toString();
                }

                break;

            case 'boolean':
            case 'array':
            default:
                $return = null;

                break;
        }

        return $return;
    }

    /**
     * Make sure that the value parameters is converted into an
     * array of strings.
     *
     * Only simple arrays (no nested arrays) are allowed here.
     * Values that cannot be converted to strings will be removed from the
     * resulting array.
     *
     * @param mixed[] $values
     *   The input values
     *
     * @return null[]|string[]
     *   The output values, should be an array of strings
     */
    protected function ensureStrings(array $values)
    {
        return \array_values(
            \array_filter(
                \array_map(
                    [$this, 'ensureString'],
                    $values
                ),
                '\is_string'
            )
        );
    }
}
