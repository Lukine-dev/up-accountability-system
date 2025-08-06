<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;
     protected $fillable = ['staff_id', 'reference_number', 'application_date','status', 'returned_at'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

        public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }
        public static function generateReferenceNumber(): string
    {
        return DB::transaction(function () {
            $datePrefix = now()->format('Ymd');

            // Lock the table for update to avoid race conditions
            DB::table('applications')->whereDate('application_date', today())->lockForUpdate()->get();

            $dailyCount = self::whereDate('application_date', today())->count();

            $sequence = str_pad($dailyCount + 1, 3, '0', STR_PAD_LEFT);

            return $datePrefix . $sequence;
        });
    }
        protected $casts = [
        'application_date' => 'datetime',
        'returned_at' => 'datetime',
    ];
    
    public function equipment()
{
    return $this->hasMany(Equipment::class);
}

}
