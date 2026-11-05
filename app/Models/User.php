<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'nip',
        'password',
        'must_change_password',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'must_change_password' => 'boolean',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function halamanBeranda()
    {
        if ($this->hasRole(Role::SUPER_ADMIN)) {
            return 'users.index';
        }

        return 'dashboard';
    }

    public function canDelete($target)
    {
        return ! $target->hasRole(Role::OWNER) && $target->id !== $this->id;
    }

    public function canResetPassword($target)
    {
        return $target->id !== $this->id;
    }
}
