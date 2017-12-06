<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 12/5/17
 * Time: 9:42 AM
 */

namespace meow\helpers;

class Inflector
{
    /**
     * Converts a CamelCase name into an ID in lowercase.
     * For example, 'FooBar' will be converted to 'foo-bar'.
     */
    public static function camel2id($name, $separator = '-', $strict = false)
    {
        $regex = $strict ? '/[A-Z]/' : '/(?<![A-Z])[A-Z]/';
        if ($separator === '_') {
            return trim(strtolower(preg_replace($regex, '_\0', $name)), '_');
        } else {
            return trim(strtolower(str_replace('_', $separator, preg_replace($regex, $separator . '\0', $name))), $separator);
        }
    }

    /**
     * Converts an ID into a CamelCase name.
     * For example, 'foo-bar' is converted to 'FooBar'.
     */
    public static function id2camel($id, $separator = '-')
    {
        return str_replace(' ', '', ucwords(implode(' ', explode($separator, $id))));
    }
}