<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'roles',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dismissals(): HasMany
    {
        return $this->hasMany(AnnouncementDismissal::class);
    }

    public function getRolesListAttribute(): array
    {
        return array_filter(array_map('trim', explode(',', $this->roles ?? '')));
    }

    public function scopeUnreadFor(Builder $query, User $user): Builder
    {
        $role = $user->role->value;

        return $query->where(function (Builder $q) use ($role) {
            $q->where('roles', $role)
                ->orWhere('roles', 'like', "{$role},%")
                ->orWhere('roles', 'like', "%,{$role}")
                ->orWhere('roles', 'like', "%,{$role},%");
        })->whereDoesntHave('dismissals', function (Builder $q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }
}
