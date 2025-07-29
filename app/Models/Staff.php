<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
     use HasFactory;
     protected $fillable = [
        'name', 'email', 'system_office', 'designation', 'department', 'status'
    ];

    protected $hidden = ['password'];

        public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
