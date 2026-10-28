<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Role;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['role', 'name', 'email', 'password', 'teacher_id', 'parent_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => Role::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }

    public function isTeacher(): bool
    {
        return $this->role === Role::TEACHER;
    }

    public function isParent(): bool
    {
        return $this->role === Role::PARENT;
    }

    public function isStudent(): bool
    {
        return $this->role === Role::STUDENT;
    }

    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', Role::ADMIN);
    }

    public function scopeTeacher(Builder $query): Builder
    {
        return $query->where('role', Role::TEACHER);
    }

    public function scopeParent(Builder $query): Builder
    {
        return $query->where('role', Role::PARENT);
    }

    public function scopeStudent(Builder $query): Builder
    {
        return $query->where('role', Role::STUDENT);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function teacherUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function parentUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function managedStudents(): HasMany
    {
        return $this->hasMany(User::class, 'teacher_id')->where('role', Role::STUDENT);
    }

    public function managedParents(): HasMany
    {
        return $this->hasMany(User::class, 'teacher_id')->where('role', Role::PARENT);
    }
}
