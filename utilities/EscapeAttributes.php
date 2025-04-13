<?php

namespace app\utilities;

trait EscapeAttributes
{
    public function escape(string $key)
    {
        $value = method_exists($this, 'getAttribute') ? $this->getAttribute($key) : $this->{$key} ?? null;

        if (is_array($value)) {
            return self::escapeArrayElements($value);
        } elseif (is_object($value)) {
            return self::escapeObjectAttributes($value);
        }

        return is_string($value) ? htmlspecialchars($value, ENT_QUOTES) : $value;
    }

    public function escapedAttributes(): array
    {
        $attributes = method_exists($this, 'toArray') ? $this->toArray() : get_object_vars($this);

        return self::escapeArrayElements($attributes);
    }

    public static function escapeObjectAttributes(Object $object) : array
    {
        $attributes = method_exists($object, 'toArray') ? $object->toArray() : get_object_vars($object);
        return self::escapeArrayElements($attributes);
    }

    public static function escapeArrayElements(array $array) : array
    {
        return array_map(function ($value)
        {
            if (is_array($value)) {
                return self::escapeArrayElements($value);
            } elseif (is_object($value)) {
                return self::escapeObjectAttributes($value);
            }

            return is_string($value) ? htmlspecialchars($value, ENT_QUOTES) : $value;

        }, $array);
    }
}