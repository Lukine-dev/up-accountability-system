<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAction;

class UserController extends Controller
{
        public function history()
    {
        $logs = UserAction::with('user')->latest()->paginate(15);
        return view('history', compact('logs'));
    }
}
