<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const OWNER = 'Owner';
    const SUPER_ADMIN = 'Super Admin';
    const ADMIN = 'Admin';
    const KEPALA_STAF_DESIGN = 'Kepala Staf Design';
    const DESAINER = 'Desainer';

    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isOwner()
    {
        return $this->name === self::OWNER;
    }
}
