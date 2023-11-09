<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use App\Models\HoaDon;
use App\Models\NhanVien;
use App\Models\SoKhamBenh;
use App\Models\Thuoc;
use App\Models\TienTrinhDieuTri;
use App\Models\VatTu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard/Dashboard', [
            'Thuoc' => Thuoc::query()->where('SoLuong', '<', 5)->get(),
            'VatTu' => VatTu::query()->where('SoLuong', '<', 5)->get(),
            'TongBenhNhan' => BenhNhan::query()->count(),
            'TongThuoc' => Thuoc::query()->get()->sum->SoLuong,
            'TongVatTu' => VatTu::query()->get()->sum->SoLuong,
            'DoanhThu' => HoaDon::whereMonth('NgayLap', Carbon::now())->get()->sum->TongSoTien,
        ]);
    }
}
