<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Customer\Models\Customer;
use Modules\Post\Database\Factories\LikeFactory;

/**
 * Class Like
 *
 * Model for likes on posts and comments
 */
class Like extends Model
{

    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'likeable_id',
        'likeable_type',
    ];

    /**
     * Get the validation rules for the model.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'likeable_id' => ['required', 'string'],
            'likeable_type' => ['required', 'string'],
        ];
    }

    /**
     * Get the customer who created the like.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the parent likeable model (post or comment).
     *
     * @return MorphTo
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return LikeFactory
     */
    protected static function newFactory(): LikeFactory
    {
        return LikeFactory::new();
    }
}
