<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Application\Helpers;

class ArrayHelper
{
    public static function toFormData($array, $prefix = '')
    {
        $result = [];
        foreach ($array as $key => $value) {
            $new_key = $prefix . (empty($prefix) ? '' : '.') . $key;

            if (is_array($value)) {
                $result = array_merge($result, self::toFormData($value, $new_key));
            } else {
                $result[$new_key] = $value;
            }
        }

        $mapped = [];
        foreach ($result as $key => $value) {
            $newKey = preg_replace_callback(
                '/\.[0-9]+/',
                fn ($matches) => '[' . preg_replace('/\D/', '', $matches[0]) . ']',
                $key
            );
            $mapped[$newKey] = $value;
        }
        return $mapped;
    }
}
