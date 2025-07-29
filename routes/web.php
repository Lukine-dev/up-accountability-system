<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\IssuedEquipmentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Resigned Staff
    Route::get('/resigned-employees', [App\Http\Controllers\HomeController::class, 'filterResigned']);
      Route::get('/latest-employees', [App\Http\Controllers\HomeController::class, 'filterLatest']);
 


    // INDIVIDUAL ROUTES
     Route::get('/issued-equipment', [IssuedEquipmentController::class, 'index'])
        ->name('monitor.issued_equipment');


    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/equipment/live-search', [EquipmentController::class, 'liveSearch'])->name('equipment.live-search');
    Route::get('/equipment/download-csv', [EquipmentController::class, 'downloadCSV'])->name('equipment.downloadCSV');


    Route::resource('staff', StaffController::class);
    Route::resource('applications', ApplicationController::class);
   


    Route::get('applications/{id}/pdf', [ApplicationController::class, 'downloadPDF'])->name('applications.pdf');
    Route::get('/applications/{id}/download-csv', [ApplicationController::class, 'downloadCSV'])->name('applications.downloadCSV');
    Route::get('/applications/download/all-csv', [ApplicationController::class, 'downloadAllCSV'])->name('applications.downloadAllCSV');



    Route::get('/staff/{id}/equipment-summary', [StaffController::class, 'downloadStaffEquipmentSummary'])
        ->name('staff.equipment.summary');

    Route::get('/staff/{id}/download-equipment-csv', [StaffController::class, 'downloadStaffEquipmentCSV'])->name('staff.downloadEquipmentCSV');

    // HISTORY LOGS
    Route::get('/history', [App\Http\Controllers\UserController::class, 'history'])->name('history');

});

// Route::middleware(['auth', 'is_superadmin'])->group(function () {
//     Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
//     Route::post('/register', [RegisteredUserController::class, 'store']);
// });
