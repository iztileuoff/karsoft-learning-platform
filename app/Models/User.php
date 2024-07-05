<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'is_admin',
        'phone',
        'email',
        'password',
        'post_id',
        'district_id',
        'school_id',
        'google_id',
        'telegram_id',
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
            'first_name' => 'string',
            'last_name' => 'string',
            'is_admin' => 'boolean',
            'phone' => 'string',
            'email' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'post_id' => 'int',
            'district_id' => 'int',
            'school_id' => 'int',
            'google_id' => 'int',
            'telegram_id' => 'int',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function password(): Attribute
    {
        return new Attribute(
            get: null,
            set: fn($value) => bcrypt($value),
        );
    }

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => $attributes['first_name'] . ' ' . $attributes['last_name'],
            set: null,
        );
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
