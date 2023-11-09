<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use App\Models\HoaDon;
use App\Models\NhanVien;
use App\Models\TienTrinhDieuTri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class BillController extends Controller
{
    public function index(Request $request): Response
    {
        $bills = HoaDon::query()->with(['nhanVien', 'benhNhan'])->where('TenHoaDon', 'LIKE', '%' . request('q') . '%')->orderBy('TenHoaDon', $request['sortType'] ?? 'asc')->paginate(10);
        return Inertia::render('Bill/List', [
            "bills" => collect($bills->items())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "TenHoaDon" => $item['TenHoaDon'],
                    "TongSoTien" => $item['TongSoTien'],
                    "NguoiTao" => $item['nhanVien']['HoVaTen'],
                    "BenhNhan" => $item['benhNhan']['HoVaTen'],
                    'TrangThai' => $item['TrangThai'],
                    'GiamGia' => $item['GiamGia'],
                    'NgayLap' => Carbon::parse($item['NgayLap'])->format('d/m/Y')
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
            'TienTrinhDieuTri' => collect(TienTrinhDieuTri::query()->whereDoesntHave('hoadon')->get())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    'name' => $item['TenTienTrinh']
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $empl = NhanVien::query()->where('MaTaiKhoan', $request->user()['Id'])->firstOrFail();
        $process = TienTrinhDieuTri::query()->with(['dichVu'])->findOrFail($request['MaTienTrinh']);

        HoaDon::create([
            'TenHoaDon' => $request['TenHoaDon'],
            'TongSoTien' => $process['dichVu']['Gia'],
            'MaBenhNhan' => $request['MaBenhNhan'],
            'MaNhanVien' => $empl['Id'],
            'MaTienTrinh' => $request['MaTienTrinh'],
            'GiamGia' => $request['GiamGia'],
            'NgayLap' => now()
        ]);
        return redirect('/hoadon');
    }

    public function pdf(int $id)
    {
        $bill = HoaDon::query()->with(['nhanVien', 'benhNhan'])->findOrFail($id);
        $process = TienTrinhDieuTri::query()->with(['thuoc', 'vatTu', 'dichVu'])->findOrFail($bill['MaTienTrinh']);
        $data = ['bill' => [
            "TenHoaDon" =>  $bill['TenHoaDon'],
            "TongSoTien" => number_format($bill['TongSoTien']),
            "NguoiTao" => $bill['nhanVien']['HoVaTen'],
            "BenhNhan" => $bill['benhNhan']['HoVaTen'],
            "GiamGia" => $bill['GiamGia'],
        ], 'process' =>   [
            "id" => $process["Id"],
            "Thuoc" => $process['thuoc']['TenThuoc'],
            "VatTu" => $process['vatTu']['TenVT'],
            "DichVu" => $process['dichVu']['TenDichVu'],
            'ChiTietDieuTri' => $process['ChiTietDieuTri'],
            'Sothuoc' => $process['Sothuoc'],
            'SoVatTu' => $process['SoVatTu'],
            'TenTienTrinh' => $process['TenTienTrinh'],
            'NgayDieuTri' => Carbon::parse($process['NgayDieuTri'])->format('d/m/Y'),
        ]];
        $pdf = PDF::loadView('hoadon', $data);
        return $pdf->download('hoadon.pdf');
    }

    public function destroy(int $id)
    {
        HoaDon::destroy($id);

        return back();
    }

    public function pay(int $id)
    {
        HoaDon::query()->findOrFail($id)->update([
            'TrangThai' => 'DaThanhToan'
        ]);

        return back();
    }
}
