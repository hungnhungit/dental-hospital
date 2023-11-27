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
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatisticalController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\UploadController;
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

    Route::post('luuanh', [UploadController::class, 'upload'])->name('upload.handle');
    Route::get('doanhthu', [RevenueController::class, 'index'])->name('doanhthu.index');
    Route::post('doanhthu/today/pdf', [RevenueController::class, 'today'])->name('doanhthutoday.pdf');
    Route::post('doanhthu/month/pdf', [RevenueController::class, 'month'])->name('doanhthumonth.pdf');
    Route::post('doanhthu/year/pdf', [RevenueController::class, 'year'])->name('doanhthuyear.pdf');
    Route::post('doanhthu/doanhthukhoangngay/pdf', [RevenueController::class, 'rangeDate'])->name('doanhthukhoangngay.pdf');
    Route::resource('taikhoan', UsersController::class);
    Route::resource('tin-tuc', NewsController::class);
    Route::resource('loai-tin-tuc', KindNewController::class);
    Route::resource('loai-thuoc', KindMedicineController::class);
    Route::resource('donvitinh', UnitController::class);
    Route::resource('loai-dich-vu', KindServicesController::class);
    Route::resource('loai-vat-tu', KindSuppliesController::class);
    Route::resource('dichvu', ServiceController::class);
    Route::post('api/benhnhan/pdf', [PatientController::class, 'pdf'])->name('benhnhan.pdf');
    Route::resource('benhnhan', PatientController::class);
    Route::post('api/thuoc/pdf', [MedicineController::class, 'pdfRemainingAmount'])->name('thuoc.pdf');
    Route::resource('thuoc', MedicineController::class);
    Route::post('api/vat-tu/pdf', [SuppliesController::class, 'pdfRemainingAmount'])->name('vat-tu.pdf');
    Route::resource('vat-tu', SuppliesController::class);
    Route::post('vat-tu/import', [SuppliesController::class, 'import'])->name('vat-tu.import');
    Route::post('thuoc/import', [MedicineController::class, 'import'])->name('thuoc.import');
    Route::post('api/hoadon/pdfList', [BillController::class, 'pdfList'])->name('hoadon.pdfList');
    Route::post('api/hoadon/{id}/pdf', [BillController::class, 'pdf'])->name('hoadon.pdf');
    Route::post('hoadon/{id}/pay', [BillController::class, 'pay'])->name('hoadon.pay');
    Route::resource('hoadon', BillController::class);
    Route::get('lichsukhambenh', [ProccessController::class, 'index'])->name('lichsukhambenh.index');
    Route::delete('tientrinhdieutri/{id}', [ProccessController::class, 'destroy'])->name('tientrinhdieutri.destroy');
    Route::post('api/sokhambenh/pdf', [HealthRecordsController::class, 'pdfList'])->name('sokham.pdfList');
    Route::get('sokhambenh/{id}/tientrinhdieutri/create', [ProccessController::class, 'create'])->name('tientrinhdieutri.create');
    Route::post('sokhambenh/{id}/tientrinhdieutri/store', [ProccessController::class, 'store'])->name('tientrinhdieutri.store');
    Route::get('sokhambenh/{id}/tientrinhdieutri/edit/{idT}', [ProccessController::class, 'edit'])->name('tientrinhdieutri.edit');
    Route::put('sokhambenh/{id}/tientrinhdieutri/edit/{idT}', [ProccessController::class, 'update'])->name('tientrinhdieutri.update');
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

Route::get('/danh-sach-bai-viet', [NewsController::class, 'blog'])->name('blog.index');

require __DIR__ . '/auth.php';
