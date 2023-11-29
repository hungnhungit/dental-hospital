<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use App\Models\DichVu;
use App\Models\HoaDon;
use App\Models\NhanVien;
use App\Models\TienTrinhDieuTri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class BillController extends Controller
{
    public function index(Request $request): Response
    {
        $bills = HoaDon::query()
            ->with(['nhanVien', 'benhNhan'])
            ->whereHas('benhNhan', function ($q) {
                $q->where('CMND', 'LIKE', '%' . request('q') . '%');
            })
            ->when(request('start'), function ($q) {
                $q->whereBetween('NgayLap', [request('start'), request('end')]);
            })
            ->when(request('q'), function ($q, $val) {
                $q->orWhere('TenHoaDon', 'LIKE', '%' . $val . '%');
            })
            ->when(request('f'), function ($q, $val) {
                $q->where('TrangThai', $val);
            })
            ->where('XoaMem', 0)
            ->orderBy('TenHoaDon', $request['sortType'] ?? 'asc')->paginate(10);

        return Inertia::render('Bill/List', [
            "bills" => collect($bills->items())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "TenHoaDon" => $item['TenHoaDon'],
                    "TongSoTien" => $item['TongSoTien'],
                    "NguoiTao" => $item['nhanVien']['HoVaTen'],
                    "BenhNhan" => $item['benhNhan']['HoVaTen'],
                    "CMND" => $item['benhNhan']['CMND'],
                    'TrangThai' => $item['TrangThai'],
                    'GiamGia' => $item['GiamGia'],
                    'NgayLap' => Carbon::parse($item['NgayLap'])->format('d/m/Y')
                ];
            }),
            "TongTien" => HoaDon::query()->get()->sum(function ($item) {
                return $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100;
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
            'DichVu' => DichVu::query()->where('XoaMem', 0)->get()->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "name" => $item['TenDichVu'],
                    "p" => $item['Gia']
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $empl = NhanVien::query()->where('MaTaiKhoan', $request->user()['Id'])->firstOrFail();

        $hoadon = HoaDon::create([
            'TenHoaDon' => $request['TenHoaDon'],
            'TongSoTien' => $request['TongSoTien'],
            'MaBenhNhan' => $request['MaBenhNhan'],
            'MaNhanVien' => $empl['Id'],
            'GiamGia' => $request['GiamGia'],
            'NgayLap' => now()
        ]);

        $hoadon->dichvu()->attach($request['services']);


        return redirect('/hoadon');
    }

    public function pdf(int $id)
    {
        $bill = HoaDon::query()->with(['nhanVien', 'benhNhan', 'dichvu'])->findOrFail($id);
        $data = ['bill' => [
            "TenHoaDon" =>  $bill['TenHoaDon'],
            "TongSoTien" => number_format($bill['TongSoTien'] - ($bill['TongSoTien'] * ($bill['GiamGia'] ?? 0)) / 100),
            "NguoiTao" => $bill['nhanVien']['HoVaTen'],
            "BenhNhan" => $bill['benhNhan']['HoVaTen'],
            "GiamGia" => $bill['GiamGia'],
            'TrangThai' => $bill->getTextStatus(),
        ], 'services' =>   $bill['dichvu']->map(function ($service) {
            return [
                'TenDichVu' => $service['TenDichVu'],
                'Gia' => $service['Gia'],
                'TongTien' => number_format($service['Gia'] * $service['payload']['SoLuong'])
            ];
        })];
        $pdf = PDF::loadView('hoadon', $data);
        return $pdf->download('hoadon.pdf');
    }

    public function destroy(int $id)
    {
        HoaDon::query()->findOrFail($id)->update([
            'XoaMem' => 1
        ]);

        return back();
    }

    public function pay(int $id)
    {
        $hoadon = HoaDon::query()->findOrFail($id);
        $benhnhan = BenhNhan::query()->findOrFail($hoadon['MaBenhNhan']);
        $hoadon->update([
            'TrangThai' => 'DaThanhToan'
        ]);

        $benhnhan->update([
            'TongTienChi' => $benhnhan['TongTienChi'] + $hoadon['TongSoTien']
        ]);

        return back();
    }

    public function pdfList()
    {
        $bills = HoaDon::query()->with(['nhanVien', 'benhNhan.sokham.bacSi', 'dichvu'])->when(request('start'), function ($q) {
            $q->whereBetween('NgayLap', [request('start'), request('end')]);
        })->where('XoaMem', 0)->where('TenHoaDon', 'LIKE', '%' . request('q') . '%')->when(request('f'), function ($q, $val) {
            $q->where('TrangThai', $val);
        })->orderBy('TenHoaDon', $request['sortType'] ?? 'asc')->get();
        $data = ["bills" => $bills->map(function ($item) {
            return [
                "TenHoaDon" => $item['TenHoaDon'],
                "TenBacSi" => Arr::get($item, 'benhNhan.sokham.bacSi.HoVaTen', ''),
                "TongSoTien" => number_format($item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100),
                "NguoiTao" => $item['nhanVien']['HoVaTen'],
                "BenhNhan" => $item['benhNhan']['HoVaTen'],
                "CMND" => $item['benhNhan']['CMND'],
                'TrangThai' => $item->getTextStatus(),
                'GiamGia' => $item['GiamGia'],
                'NgayLap' => Carbon::parse($item['NgayLap'])->format('d/m/Y'),
                "DichVu" => $item['dichvu']->map(function ($item) {
                    return [
                        'TenDichVu' => $item['TenDichVu'],
                        'SoLuong' => $item['payload']['SoLuong']
                    ];
                })
            ];
        }), "TongTien" => number_format($bills->sum(function ($item) {
            return $item['TongSoTien'] - ($item['TongSoTien'] * ($item['GiamGia'] ?? 0)) / 100;
        }))];
        $pdf = PDF::loadView('danhsachhoadon', $data);
        return $pdf->download('danhsachhoadon.pdf');
    }
}
