<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserAction extends Model
{
    protected $fillable = [
        'user_id', 'action', 'model', 'model_id', 'description'
    ];

    public static function log($action, $description, $model, $modelId = null)
    {
        self::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'model' => $model,
            'model_id' => $modelId,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
