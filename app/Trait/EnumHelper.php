<?php
namespace App\Trait;

use Illuminate\Validation\Rules\Enum;

trait EnumHelper
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }
    public static function getValueFromName(string $name): string
    {
        return constant(self::class . '::' . $name)->value;
    }
    public static function getEnumFromName(string $name): static
    {
        return constant(self::class . '::' . $name);
    }
}
