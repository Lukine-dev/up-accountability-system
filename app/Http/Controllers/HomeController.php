<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Application;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
            public function index()
        {
            return view('home', [
                'totalStaff' => Staff::count(),
                'activeStaff' => Staff::where('status', 'active')->count(),
                'resignedStaff' => Staff::where('status', 'resigned')->count(),
                'totalApplications' => Application::count(),
                'totalEquipmentReleased' => Equipment::sum('quantity'),
            ]);
        }
}