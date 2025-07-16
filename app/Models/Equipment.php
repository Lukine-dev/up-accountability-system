<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description','model_brand', 'serial_number', 'quantity'];

        public function application()
    {
        return $this->belongsTo(Application::class);
    }
    

}
