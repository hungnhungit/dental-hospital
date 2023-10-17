<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\HoaDon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BillController extends Controller
{
    public function index(): Response
    {
        $bills = HoaDon::with(['nhanVien', 'benhNhan'])->paginate(10);
        return Inertia::render('Bill/List', [
            "bills" => collect($bills->items())->map(function ($item) {
                return [
                    "TenHoaDon" => $item['TenHoaDon'],
                    "TongSoTien" => $item['TongSoTien'],
                    "NguoiTao" => $item['nhanVien']['HoVaTen'],
                    "BenhNhan" => $item['benhNhan']['HoVaTen'],
                    'TrangThai' => $item['TrangThai']
                ];
            }),
            "totalPage" => $bills->total(),
        ]);
    }
}
