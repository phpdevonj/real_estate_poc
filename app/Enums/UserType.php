<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Admin()
 * @method static static Agent()
 */
final class UserType extends Enum
{
    const Admin = 0;
    const Agent = 1;

    /**
     * Get the description for an enum value
     *
     * @param mixed $value
     * @return string
     */
    public static function getDescription($value): string
    {
        return match ($value) {
            self::Admin => 'Admin',
            self::Agent => 'Agent',
            default => 'Unknown',
        };
    }

    /**
     * Convert the enum to an array suitable for select inputs
     *
     * @return array
     */
    public static function toSelectArray(): array
    {
        return [
            self::Admin => self::getDescription(self::Admin),
            self::Agent => self::getDescription(self::Agent),
        ];
    }

    /**
     * Convert the enum to an array with value and label keys
     *
     * @return array
     */
    public static function toStaticArray(): array
    {
        return array_map(fn($value, $description) => [
            'value' => $value,
            'label' => $description,
        ], array_keys(self::toArray()), self::toArray());
    }

    public function isAdmin(): bool
    {
        return $this->value === self::Admin;  // Changed from $this->role to $this->value
    }

    public function isAgent(): bool
    {
        return $this->value === self::Agent;  // Changed from $this->role to $this->value
    }
}
