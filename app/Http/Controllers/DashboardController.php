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
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'TongBenhNhan' => BenhNhan::query()->count(),
            'TongThuoc' => Thuoc::query()->get()->sum->SoLuong,
            'TongVatTu' => VatTu::query()->get()->sum->SoLuong,
            'DoanhThu' => HoaDon::query()->get()->sum->TongSoTien,
        ]);
    }
}
