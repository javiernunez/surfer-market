<?php

namespace App\Domain\Global\Enum;

enum Unit: string
{
    case GRAM = 'g';
    case KILOGRAM = 'kg';

    public static function fromString(string $value): Unit
    {
        return match ($value) {
            'g' => self::GRAM,
            'kg' => self::KILOGRAM,
            default => throw new \InvalidArgumentException("Invalid unit: $value"),
        };
    }
}
