<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['shift_id', 'nama', 'jabatan', 'email', 'password'];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function presence()
    {
        return $this->hasMany(Presence::class);
    }
}
