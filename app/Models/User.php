<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'bio',
        'avatar_url',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * A User (Teacher/Creator/Admin) has many videos.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'user_id');
    }

    /**
     * Get user avatar URL with graceful fallback
     */
    public function getAvatarAttribute(): string
    {
        if (!empty($this->avatar_url)) {
            return $this->avatar_url;
        }

        // SVG Avatar fallback
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=ffffff&bold=true&size=128';
    }

    /**
     * Role styling badge helper
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match (strtolower($this->role ?? 'teacher')) {
            'admin' => 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20',
            'teacher' => 'bg-purple-500/10 text-purple-400 border border-purple-500/20',
            'creator' => 'bg-amber-500/10 text-amber-400 border border-amber-500/20',
            'editor' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20',
            default => 'bg-gray-700/50 text-gray-300 border border-gray-600/30',
        };
    }

    /**
     * Status styling badge helper
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match (strtolower($this->status ?? 'active')) {
            'active' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20',
            'inactive' => 'bg-rose-500/10 text-rose-400 border border-rose-500/20',
            'suspended' => 'bg-amber-500/10 text-amber-400 border border-amber-500/20',
            default => 'bg-gray-700/50 text-gray-300 border border-gray-600/30',
        };
    }
}
