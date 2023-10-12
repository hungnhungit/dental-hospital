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
        return Inertia::render('Bill/List');
    }

    public function paginate(Request $request)
    {
        $bills = HoaDon::with(['nhanVien', 'benhNhan', 'phuongThuc'])->paginate(10);

        return [
            "bills" => collect($bills->items())->map(function ($item) {
                return [
                    "code" => $item['MaHoaDon'],
                    "total" => $item['TongTien'],
                    "created_by" => $item['nhanVien']['HoVaTen'],
                    "patient" => $item['benhNhan']['HoVaTen'],
                    'status' => $item['phuongThuc']['TrangThai'],
                    'payment' => $item['phuongThuc']['TenHinhThucThanhToan'],
                ];
            }),
            "totalPage" => $bills->total(),
        ];
    }
}
