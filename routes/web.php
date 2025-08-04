<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\IssuedEquipmentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserController;

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
    Route::get('/history', [UserController::class, 'history'])->name('history');
    Route::post('/history/delete', [UserController::class, 'deleteHistoryByDate'])->name('history.deleteByDate');
    Route::get('/history/preview-count', [UserController::class, 'previewLogCount'])->name('history.previewCount');
    Route::get('/history/export', [UserController::class, 'exportLogsByDate'])->name('history.export');
    Route::get('/history/filter', [UserController::class, 'filterByDate']);

     // User Management Routes (restricted to authenticated users)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

});

// Route::middleware(['auth', 'is_superadmin'])->group(function () {
//     Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
//     Route::post('/register', [RegisteredUserController::class, 'store']);
// });
