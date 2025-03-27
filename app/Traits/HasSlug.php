<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait HasSlug
 *
 * This trait is used to add slug functionality to a model.
 *
 * @mixin Model
 * @property string $slug
 * @property string $name
 */
trait HasSlug
{

    /**
     * Generate a slug for the model.
     *
     * @return void
     */
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->slug = $model->slug ?? $model->getSlugValue();
        });
    }

    /**
     * Define the slug attribute.
     *
     * @return Attribute
     */
    protected function slug(): Attribute
    {
        return Attribute::set(fn ($value) => Str::slug($value));
    }

    /**
     * Generate a slug for the model.
     *
     * @return string
     */
    public function getSlugValue(): string
    {
        return $this->name;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
