<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use App\Models\HoaDon;
use App\Models\NhanVien;
use App\Models\TienTrinhDieuTri;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class BillController extends Controller
{
    public function index(): Response
    {
        $bills = HoaDon::with(['nhanVien', 'benhNhan'])->paginate(10);
        return Inertia::render('Bill/List', [
            "bills" => collect($bills->items())->map(function ($item) {
                return [
                    "id" => $item["Id"],
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

    public function create()
    {
        return Inertia::render('Bill/New', [
            'BenhNhan' => collect(BenhNhan::all())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "name" => $item['HoVaTen']
                ];
            }),
            'TienTrinhDieuTri' => collect(TienTrinhDieuTri::all())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    'NgayDieuTri' => $item['NgayDieuTri']
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $empl = NhanVien::query()->where('MaTaiKhoan', $request->user()['Id'])->firstOrFail();

        HoaDon::create([
            'TenHoaDon' => $request['TenHoaDon'],
            'TongSoTien' => 10000,
            'MaBenhNhan' => $request['MaBenhNhan'],
            'MaNhanVien' => $empl['Id']
        ]);
        return redirect('/hoadon');
    }

    public function pdf(int $id)
    {
        $bill = HoaDon::query()->with(['nhanVien', 'benhNhan'])->findOrFail($id);
        $data = ['bill' => [
            "TenHoaDon" =>  $bill['TenHoaDon'],
            "TongSoTien" => number_format($bill['TongSoTien']),
            "NguoiTao" => $bill['nhanVien']['HoVaTen'],
            "BenhNhan" => $bill['benhNhan']['HoVaTen'],
        ]];
        $pdf = PDF::loadView('hoadon', $data);
        return $pdf->download('hoadon.pdf');
    }
}
