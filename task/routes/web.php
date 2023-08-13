<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('companies', CompanyController::class);
// Route::resource('employees', EmployeeController::class);

Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get("/employees/create", [EmployeeController::class, 'create'])->name('employees.create');
Route::post("/employees/store", [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
Route::get('/employees/{id}/destroy', [EmployeeController::class, 'destroy'])->name('employees.destroy');
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::post('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::post("/company/store", [CompanyController::class, 'store'])->name('company.store');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
