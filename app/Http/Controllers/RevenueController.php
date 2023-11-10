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
        $months = array_fill(0, 12, 0);
        $today = array_fill(0, 12, 0);
        HoaDon::whereYear('NgayLap', Carbon::now()->format('Y'))->where('TrangThai', 'DaThanhToan')->get()->each(function ($item) use (&$months, &$today) {
            $date = Carbon::parse($item['NgayLap']);
            $total = $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0) / 100);
            $months[$date->month - 1] += $total;
            if ($date->isToday()) {
                $today[$date->month - 1] += $total;
            }
        });
        return Inertia::render('Revenue/List', [
            "today" => $today,
            "months" => $months
        ]);
    }
}
