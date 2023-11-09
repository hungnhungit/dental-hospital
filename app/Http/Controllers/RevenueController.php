<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class RevenueController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Revenue/List', [
            "today" => HoaDon::whereDate('NgayLap', Carbon::now())->where('TrangThai', 'DaThanhToan')->get()->sum(function ($item) {
                return $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0) / 100);
            }),
            "month" => HoaDon::whereMonth('NgayLap', Carbon::now())->where('TrangThai', 'DaThanhToan')->get()->sum(function ($item) {
                return $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0) / 100);
            }),
            "year" => HoaDon::whereYear('NgayLap', Carbon::now())->where('TrangThai', 'DaThanhToan')->get()->sum(function ($item) {
                return $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0) / 100);
            }),
        ]);
    }
}
