<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Application;
use App\Models\Equipment;
use App\Models\User;
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
                'departments' => Staff::whereNotNull('department')->distinct()->pluck('department'),
                'resignedEmployees' => Staff::where('status', 'resigned')->latest('updated_at')->take(10)->get(),
                'latestEmployees' => Staff::where('status', 'active')->latest('created_at')->take(10)->get(),
                'users' => User::latest()->paginate(10),
            ]);
        }
                public function filterResigned(Request $request)
        {
            $query = Staff::where('status', 'resigned');

            if ($request->filled('department')) {
                $query->where('department', $request->department);
            }

            $employees = $query->latest('updated_at')->take(10)->get();

            return view('partials.resigned-employees', compact('employees'));
        }
             public function filterLatest(Request $request)
        {
            $query = Staff::where('status', 'active');

            if ($request->filled('department')) {
                $query->where('department', $request->department);
            }

            $employees = $query->latest('created_at')->take(10)->get();

            return view('partials.latest-employees', compact('employees'));
        }
        
       
}