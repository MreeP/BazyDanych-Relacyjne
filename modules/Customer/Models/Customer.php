<?php

namespace Modules\Customer\Models;

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
use Laravel\Sanctum\HasApiTokens;
use Modules\Customer\Database\Factories\CustomerFactory;
use Modules\Customer\Notifications\Auth\ResetPassword;
use Modules\Customer\Notifications\Auth\VerifyEmail;
use SensitiveParameter;

/**
 * Class Customer
 *
 * Class used to represent the Customer model.
 */
class Customer extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authorizable;
    use Authenticatable;
    use CanResetPassword;
    use HasApiTokens;
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
     * Get the validation rules for the model.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Customer::class],
            'password' => ['required', 'confirmed', new Password('customer')],
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

    /**
     * Get the validation rules for the password reset.
     *
     * @return array
     */
    public static function passwordResetRules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => static::rules()['password'],
        ];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail());
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification(#[SensitiveParameter] $token): void
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return CustomerFactory
     */
    protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }
}
