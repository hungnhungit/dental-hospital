<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExaminationScheduleController;
use App\Http\Controllers\HealthRecordsController;
use App\Http\Controllers\KindMedicineController;
use App\Http\Controllers\KindNewController;
use App\Http\Controllers\KindServicesController;
use App\Http\Controllers\KindSuppliesController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProccessController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SickConditionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuppliesController;
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
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/trangchu', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/taikhoan', [UsersController::class, 'index'])->name('users.list');
    Route::post('/taikhoan', [UsersController::class, 'store'])->name('users.store');
    Route::get('/taikhoan/tao-moi', [UsersController::class, 'new'])->name('users.new');
    Route::delete('/taikhoan', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::resource('tin-tuc', NewsController::class);
    Route::resource('loai-tin-tuc', KindNewController::class);
    Route::resource('loai-thuoc', KindMedicineController::class);
    Route::resource('donvitinh', UnitController::class);
    Route::resource('loai-dich-vu', KindServicesController::class);
    Route::resource('loai-vat-tu', KindSuppliesController::class);
    Route::resource('dichvu', ServiceController::class);
    Route::resource('benhnhan', PatientController::class);
    Route::resource('thuoc', MedicineController::class);
    Route::resource('vat-tu', SuppliesController::class);
    Route::post('api/hoadon/{id}/pdf', [BillController::class, 'pdf'])->name('hoadon.pdf');
    Route::resource('hoadon', BillController::class);
    Route::delete('tientrinhdieutri', [ProccessController::class, 'destroy']);
    Route::get('sokhambenh/{id}tientrinhdieutri/create', [ProccessController::class, 'create']);
    Route::post('api/sokhambenh/{id}/pdf', [HealthRecordsController::class, 'pdf'])->name('sokhambenh.pdf');
    Route::resource('sokhambenh', HealthRecordsController::class);
    Route::post('sokhambenh/{id}/changeStatus', [HealthRecordsController::class, 'changeStatus'])->name('sokhambenh.changeStatus');
    Route::get('quyen', [RoleController::class, 'index'])->name('quyen.index');
    Route::get('quyen/{id}/phanquyen', [RoleController::class, 'show'])->name('quyen.show');
    Route::post('quyen/{id}/phanquyen', [RoleController::class, 'update'])->name('quyen.update');


    Route::get('/caidat', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
