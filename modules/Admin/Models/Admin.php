<?php

namespace Modules\Admin\Models;

use App\Rules\Password;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Modules\Admin\Database\Factories\AdminFactory;

/**
 * Class Admin
 *
 * Class used to represent the Admin model.
 */
class Admin extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authorizable;
    use Authenticatable;
    use CanResetPassword;
    use HasFactory;
    use HasUuids;
    use MustVerifyEmail;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return AdminFactory
     */
    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }

    /**
     * Get the validation rules for the model.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Admin::class],
            'password' => ['required', 'confirmed', new Password('admin')],
        ];
    }

    /**
     * Get the validation rules for the password reset.
     *
     * @return array
     */
    public static function passwordUpdateRules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => static::rules()['password'],
        ];
    }
}
