<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\ExaminationScheduleController;
use App\Http\Controllers\HealthRecordsController;
use App\Http\Controllers\KindMedicineController;
use App\Http\Controllers\KindNewController;
use App\Http\Controllers\KindServicesController;
use App\Http\Controllers\KindSuppliesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SickConditionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/taikhoan', [UsersController::class, 'index'])->name('users.list');
    Route::post('/taikhoan', [UsersController::class, 'store'])->name('users.store');
    Route::get('/taikhoan/tao-moi', [UsersController::class, 'new'])->name('users.new');
    Route::delete('/taikhoan', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::get('/benhnhan', [PatientController::class, 'index'])->name('patients.list');
    Route::get('/dichvu', [ServiceController::class, 'index'])->name('services.list');
    Route::get('/loai-dich-vu', [KindServicesController::class, 'index'])->name('kind_services.list');
    Route::get('/hoadon', [BillController::class, 'index'])->name('bills.list');
    Route::get('/examination-schedule', [ExaminationScheduleController::class, 'index'])->name('examination_schedule.list');

    Route::get('/tin-tuc', [NewsController::class, 'index'])->name('news.list');
    Route::get('/tin-tuc/tao-moi', [NewsController::class, 'new'])->name('news.new');
    Route::get('/tin-tuc/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/tin-tuc/{id}/update', [NewsController::class, 'update'])->name('news.update');
    Route::post('/tin-tuc', [NewsController::class, 'store'])->name('news.store');
    Route::delete('/tin-tuc/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    Route::get('/loai-tin-tuc', [KindNewController::class, 'index'])->name('kind_new.list');
    Route::get('/loai-tin-tuc/tao-moi', [KindNewController::class, 'new'])->name('kind_new.new');
    Route::get('/loai-tin-tuc/{id}/edit', [KindNewController::class, 'edit'])->name('kind_new.edit');
    Route::put('/loai-tin-tuc/{id}/update', [KindNewController::class, 'update'])->name('kind_new.update');
    Route::post('/loai-tin-tuc', [KindNewController::class, 'store'])->name('kind_new.store');
    Route::delete('/loai-tin-tuc/{id}', [KindNewController::class, 'destroy'])->name('kind_new.destroy');

    Route::get('/donvitinh', [UnitController::class, 'index'])->name('units.list');
    Route::get('/loai-vat-tu', [KindSuppliesController::class, 'index'])->name('supplies.list');
    Route::get('/loai-thuoc', [KindMedicineController::class, 'index'])->name('kindMedicine.list');
    Route::get('/loai-thuoc/tao-moi', [KindMedicineController::class, 'new'])->name('kindMedicine.new');
    Route::get('/loai-thuoc/{id}/edit', [KindMedicineController::class, 'edit'])->name('kindMedicine.edit');
    Route::put('/loai-thuoc/{id}', [KindMedicineController::class, 'update'])->name('kindMedicine.update');
    Route::post('/loai-thuoc', [KindMedicineController::class, 'store'])->name('kindMedicine.store');
    Route::delete('/loai-thuoc', [KindMedicineController::class, 'destroy'])->name('kindMedicine.destroy');
    Route::get('/sick', [SickConditionController::class, 'index'])->name('sick.list');
    Route::get('/health-records', [HealthRecordsController::class, 'index'])->name('health_records.list');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('api')->group(function () {
    Route::delete("/api/users", [UsersController::class, 'destroy']);
    Route::get("/api/patients", [PatientController::class, 'paginate']);
    Route::get("/api/services", [ServiceController::class, 'paginate']);
    Route::get("/api/kind-services", [KindServicesController::class, 'paginate']);
    Route::get("/api/bills", [BillController::class, 'paginate']);
    Route::get("/api/examination-schedule", [ExaminationScheduleController::class, 'paginate']);
    Route::get("/api/news", [NewsController::class, 'paginate']);
    Route::get("/api/sick", [SickConditionController::class, 'paginate']);
    Route::get("/api/health-records", [HealthRecordsController::class, 'paginate']);
    Route::get("/api/units", [UnitController::class, 'paginate']);
    Route::get("/api/supplies", [KindSuppliesController::class, 'paginate']);
    Route::post("/api/users", [UsersController::class, 'create']);
});

Route::get('/register-examination-schedule', [ExaminationScheduleController::class, 'register'])->name('register');

require __DIR__ . '/auth.php';
