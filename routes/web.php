<?php

use App\Http\Controllers\Auth\BillController;
use App\Http\Controllers\Auth\ExaminationScheduleController;
use App\Http\Controllers\Auth\HealthRecordsController;
use App\Http\Controllers\Auth\KindNewController;
use App\Http\Controllers\Auth\KindServicesController;
use App\Http\Controllers\Auth\NewsController;
use App\Http\Controllers\Auth\PatientController;
use App\Http\Controllers\Auth\ServiceController;
use App\Http\Controllers\Auth\SickConditionController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    });

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/users', [UsersController::class, 'index'])->name('users.list');
    Route::get('/users/new', [UsersController::class, 'index'])->name('users.new');
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.list');
    Route::get('/services', [ServiceController::class, 'index'])->name('services.list');
    Route::get('/kind-services', [KindServicesController::class, 'index'])->name('kind_services.list');
    Route::get('/bills', [BillController::class, 'index'])->name('bills.list');
    Route::get('/examination-schedule', [ExaminationScheduleController::class, 'index'])->name('examination_schedule.list');
    Route::get('/news', [NewsController::class, 'index'])->name('news.list');
    Route::get('/kind-new', [KindNewController::class, 'index'])->name('kind_new.list');
    Route::get('/sick', [SickConditionController::class, 'index'])->name('sick.list');
    Route::get('/health-records', [HealthRecordsController::class, 'index'])->name('health_records.list');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('api')->group(function () {
    Route::get("/api/users", [UsersController::class, 'paginate']);
    Route::delete("/api/users", [UsersController::class, 'destroy']);
    Route::get("/api/patients", [PatientController::class, 'paginate']);
    Route::get("/api/services", [ServiceController::class, 'paginate']);
    Route::get("/api/kind-services", [KindServicesController::class, 'paginate']);
    Route::get("/api/bills", [BillController::class, 'paginate']);
    Route::get("/api/examination-schedule", [ExaminationScheduleController::class, 'paginate']);
    Route::get("/api/news", [NewsController::class, 'paginate']);
    Route::get("/api/kind-new", [KindNewController::class, 'paginate']);
    Route::get("/api/sick", [SickConditionController::class, 'paginate']);
    Route::get("/api/health-records", [HealthRecordsController::class, 'paginate']);
});

Route::get('/register-examination-schedule', [ExaminationScheduleController::class, 'register'])->name('register');

require __DIR__ . '/auth.php';
