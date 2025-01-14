<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\Self_;

class User extends Authenticatable implements FilamentUser
{
   
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const ADMIN = "ADMIN";
    const EDITOR = "EDITOR";
    const USER = "USER";
    const DEFAULT_ROLE = self::USER;
    const ROLES = [
        self::ADMIN => 'Admin',
        self::EDITOR => 'Editor',
        self::USER => 'User'
    ];

    public function canAccessPanel(Panel $panel): bool 
    {
        return $this->can('view-admin', User::class);
    }
    public function isAdmin()
    {
        return $this->role === self::ADMIN;
    }
    public function isEditor()
    {
        return $this->role === self::EDITOR;
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'post_like')->withTimestamps();
    }
    public function hasLiked(Post $post)
    {
        return $this->likes()->where('post_id', $post->id)->exists();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
