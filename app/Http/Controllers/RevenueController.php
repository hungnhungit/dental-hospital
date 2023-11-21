<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DichVu;
use App\Models\HoaDon;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class RevenueController extends Controller
{
    public function index(): Response
    {
        $months = array_fill(0, 12, 0);
        $today = array_fill(0, 12, 0);
        $services = array_fill(0, 12, []);
        $servicesCount = array_fill(0, 12, []);
        $servicesLabel = [];
        HoaDon::whereYear('NgayLap', Carbon::now()->format('Y'))->with(['dichvu'])->where('TrangThai', 'DaThanhToan')->where('XoaMem', 0)->get()->each(function ($item) use (&$months, &$today, &$services) {
            $date = Carbon::parse($item['NgayLap']);
            $total = $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0) / 100);
            $months[$date->month - 1] += $total;
            $arrServiceId = array_keys($services[$date->month - 1]);
            $item['dichvu']->each(function ($service) use ($arrServiceId, $date, &$services) {
                if (in_array($service['Id'], $arrServiceId)) {
                    $services[$date->month - 1][$service['Id']] +=  $service['payload']['SoLuong'];
                } else {
                    $services[$date->month - 1][$service['Id']] =  $service['payload']['SoLuong'];
                }
            });
            if ($date->isToday()) {
                $today[$date->month - 1] += $total;
            }
        });
        collect($services)->each(function ($item, $key) use (&$servicesCount, &$servicesLabel) {
            if (count($item) > 0) {
                $servicesCount = array_fill(0, 12, 0);
                $id = array_keys($item)[0];
                $s = DichVu::query()->where('Id', $id)->first();
                $servicesCount[$key] = max(array_values($item));
                $servicesLabel[] = [
                    "data" => $servicesCount,
                    "name" => $s['TenDichVu']
                ];
            }
        });
        return Inertia::render('Revenue/List', [
            "today" => $today,
            "months" => $months,
            "servicesLabel" => $servicesLabel
        ]);
    }

    public function today()
    {
        $bills = HoaDon::query()
            ->whereDate('NgayLap', Carbon::today())
            ->with(['nhanVien', 'benhNhan'])
            ->where('TrangThai', 'DaThanhToan')
            ->where('XoaMem', 0)
            ->get();

        $data = ["bills" => $bills->map(function ($item) {
            return [
                "TenHoaDon" => $item['TenHoaDon'],
                "TongSoTien" => number_format($item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100),
                "NguoiTao" => $item['nhanVien']['HoVaTen'],
                "BenhNhan" => $item['benhNhan']['HoVaTen'],
                'TrangThai' => $item->getTextStatus(),
                'GiamGia' => $item['GiamGia'],
                'NgayLap' => Carbon::parse($item['NgayLap'])->format('d/m/Y')
            ];
        }), "TongTien" => number_format($bills->sum(function ($item) {
            return $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100;
        }))];
        $pdf = PDF::loadView('danhsachhoadon', $data);
        return $pdf->download('danhsachhoadon.pdf');
    }

    public function month()
    {
        $bills = HoaDon::query()
            ->whereMonth('NgayLap', Carbon::now()->format('m'))
            ->with(['nhanVien', 'benhNhan'])
            ->where('TrangThai', 'DaThanhToan')
            ->where('XoaMem', 0)
            ->get();

        $data = ["bills" => $bills->map(function ($item) {
            return [
                "TenHoaDon" => $item['TenHoaDon'],
                "TongSoTien" => number_format($item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100),
                "NguoiTao" => $item['nhanVien']['HoVaTen'],
                "BenhNhan" => $item['benhNhan']['HoVaTen'],
                'TrangThai' => $item->getTextStatus(),
                'GiamGia' => $item['GiamGia'],
                'NgayLap' => Carbon::parse($item['NgayLap'])->format('d/m/Y')
            ];
        }), "TongTien" => number_format($bills->sum(function ($item) {
            return $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100;
        }))];
        $pdf = PDF::loadView('danhsachhoadon', $data);
        return $pdf->download('danhsachhoadon.pdf');
    }

    public function year()
    {
        $bills = HoaDon::query()
            ->whereYear('NgayLap', Carbon::now()->format('Y'))
            ->with(['nhanVien', 'benhNhan'])
            ->where('TrangThai', 'DaThanhToan')
            ->where('XoaMem', 0)
            ->get();

        $data = ["bills" => $bills->map(function ($item) {
            return [
                "TenHoaDon" => $item['TenHoaDon'],
                "TongSoTien" => number_format($item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100),
                "NguoiTao" => $item['nhanVien']['HoVaTen'],
                "BenhNhan" => $item['benhNhan']['HoVaTen'],
                'TrangThai' => $item->getTextStatus(),
                'GiamGia' => $item['GiamGia'],
                'NgayLap' => Carbon::parse($item['NgayLap'])->format('d/m/Y')
            ];
        }), "TongTien" => number_format($bills->sum(function ($item) {
            return $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100;
        }))];
        $pdf = PDF::loadView('danhsachhoadon', $data);
        return $pdf->download('danhsachhoadon.pdf');
    }
}
