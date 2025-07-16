<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\IssuedEquipmentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    


    // INDIVIDUAL ROUTES
     Route::get('/issued-equipment', [IssuedEquipmentController::class, 'index'])
        ->name('monitor.issued_equipment');

    Route::resource('staff', StaffController::class);
    Route::resource('applications', ApplicationController::class);
   

    Route::get('applications/{id}/pdf', [ApplicationController::class, 'downloadPDF'])->name('applications.pdf');

    Route::get('/staff/{id}/equipment-summary', [StaffController::class, 'downloadStaffEquipmentSummary'])
        ->name('staff.equipment.summary');
});

// Route::middleware(['auth', 'is_superadmin'])->group(function () {
//     Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
//     Route::post('/register', [RegisteredUserController::class, 'store']);
// });
