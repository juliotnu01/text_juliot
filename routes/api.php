<?php


use App\Http\Controllers\{EmployeeController, DepartmentController };
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get-employees', [EmployeeController::class, 'index'])->name('get.room.employee');
Route::get('/get-departments', [DepartmentController::class, 'index'])->name('get.department');
Route::post('/store-employee', [EmployeeController::class, 'store'])->name('store.employee.room');
Route::put('/update-employee/{employee}', [EmployeeController::class, 'update'])->name('update.employee');
Route::put('/update-active-employee/{employee}', [EmployeeController::class, 'updateActiveEmployee'])->name('update.active.employee');