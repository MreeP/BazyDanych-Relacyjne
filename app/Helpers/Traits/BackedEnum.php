<?php

namespace App\Helpers\Traits;

/**
 * Trait BackedEnum
 *
 * Trait for extending php backed enums.
 */
trait BackedEnum
{

    /**
     * Get the key of the enum.
     *
     * @return string
     */
    public function key(): string
    {
        return $this->name;
    }

    /**
     * Get the value of the enum.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Get the value of the enum.
     *
     * @return string
     */
    public function label(): string
    {
        return __($this->value);
    }

    /**
     * Determines if the current enum is equal to the other.
     *
     * @param  self $other
     * @return bool
     */
    public function is(self $other): bool
    {
        return $this->key() === $other->key();
    }

    /**
     * Determines if the current enum is not equal to the other.
     *
     * @param  self $other
     * @return bool
     */
    public function isNot(self $other): bool
    {
        return $this->key() !== $other->key();
    }

    /**
     * Determines if the current enum is one of the others.
     *
     * @param  array $others
     * @return bool
     */
    public function any(array $others): bool
    {
        foreach ($others as $other) {
            if (is_a($other, static::class) && $this->is($other)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines if the current enum is none of the others.
     *
     * @param  array $others
     * @return bool
     */
    public function none(array $others): bool
    {
        foreach ($others as $other) {
            if (is_a($other, static::class) && $this->is($other)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns all enum options.
     *
     * @return array
     */
    public static function list(): array
    {
        return array_map(
            fn ($item) => __($item),
            array_column(static::cases(), 'value', 'name'),
        );
    }
}
