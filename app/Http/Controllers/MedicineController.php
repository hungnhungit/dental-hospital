<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonViTinh;
use App\Models\LoaiThuoc;
use App\Models\NhapXuatThuoc;
use App\Models\Thuoc;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $medicines = Thuoc::query()->with(['loaiThuoc', 'donVi'])->when(request('f'), function ($q, $val) {
            $q->where('SoLuong', $val === 'het' ? '=' : '>', 0);
        })->where('TenThuoc', 'LIKE', '%' . request('q') . '%')->orderBy('TenThuoc', $request['sortType'] ?? 'asc')->paginate(10);
        return Inertia::render('Medicine/List', [
            "medicines" => collect($medicines->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "TenThuoc" => $item['TenThuoc'],
                    "LoaiThuoc" => $item['loaiThuoc']['LoaiThuoc'],
                    "DonVi" => $item['donVi']['DonVi'],
                    "CongDung" => $item['CongDung'],
                    "CachDung" => $item['CachDung'],
                    "SoLuong" => $item['SoLuong'],
                    "HSD" => Carbon::parse($item['HSD'])->format('d/m/Y'),
                ];
            }),
            "totalPage" => $medicines->total(),
            "medicineOptions" => Thuoc::all()->map(function ($item) {
                return [
                    'id' => $item['Id'],
                    'name' => $item['TenThuoc'],
                ];
            })
        ]);
    }

    public function create()
    {
        return Inertia::render('Medicine/New', [
            'units' => collect(DonViTinh::all())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['DonVi'],
                ];
            }),
            'kinds' => collect(LoaiThuoc::all())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['LoaiThuoc'],
                ];
            })
        ]);
    }

    public function edit(int $id)
    {
        $record  = Thuoc::query()->findOrFail($id);
        return Inertia::render('Medicine/New', [
            'units' => collect(DonViTinh::all())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['DonVi'],
                ];
            }),
            'kinds' => collect(LoaiThuoc::all())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['LoaiThuoc'],
                ];
            }),
            "medicine" => $record->toArray(),
            "history" => NhapXuatThuoc::query()->get()->map(function ($item) {
                return array_merge($item->toArray(), [
                    'NgayBienDong' => Carbon::parse($item['NgayBienDong'])->format('d/m/Y')
                ]);
            }),
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = Thuoc::query()->findOrFail($id);

        $record->update($request->all());

        return redirect('/thuoc');
    }

    public function store(Request $request)
    {
        Thuoc::create($request->all());
        return redirect('/thuoc');
    }

    public function destroy(int $id)
    {
        Thuoc::destroy($id);

        return back();
    }

    public function pdfRemainingAmount()
    {
        $medicines =  Thuoc::with(['loaiThuoc', 'donVi', 'nhapxuat'])->when(request('f'), function ($q, $val) {
            $q->where('SoLuong', $val === 'het' ? '=' : '>', 0);
        })->get();
        $data = ["data" => collect($medicines)->map(function ($item) {
            return [
                "id" => $item['Id'],
                "Ten" => $item['TenThuoc'],
                "LoaiThuoc" => $item['loaiThuoc']['LoaiThuoc'],
                "DonVi" => $item['donVi']['DonVi'],
                "SoLuongNhap" => $item['nhapxuat']->sum->SoLuongNhap,
                "SoLuongXuat" => $item['nhapxuat']->sum->SoLuongXuat,
                "SoLuongHienTai" => $item['SoLuong'],
            ];
        })];
        $pdf = PDF::loadView('thuoc', $data);
        return $pdf->download('thuoc.pdf');
    }

    public function import()
    {
        $thuoc = Thuoc::query()->findOrFail(request('MaThuoc'));


        NhapXuatThuoc::query()->create([
            'MaThuoc' => request('MaThuoc'),
            'NgayBienDong' => request('NgayNhap'),
            'SoLuongNhap' => request('SoLuong'),
            'SoLuongHienTai' => $thuoc['SoLuong']
        ]);

        $thuoc->update([
            'SoLuong' => $thuoc['SoLuong'] + request('SoLuong')
        ]);

        return back();
    }
}
