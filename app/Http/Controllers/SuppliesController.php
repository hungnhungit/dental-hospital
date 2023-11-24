<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonViTinh;
use App\Models\LoaiVatTu;
use App\Models\NhapXuatVatTu;
use App\Models\VatTu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class SuppliesController extends Controller
{
    public function index(Request $request): Response
    {
        $supplies = VatTu::query()->with(['loaiVatTu', 'donVi'])->when(request('f'), function ($q, $val) {
            $q->where('SoLuong', $val === 'het' ? '=' : '>', 0);
        })->where('TenVT', 'LIKE', '%' . request('q') . '%')->orderBy('TenVT', $request['sortType'] ?? 'asc')->paginate(10);

        return Inertia::render('Supplies/List', [
            "supplies" => collect($supplies->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "TenVT" => $item['TenVT'],
                    "LoaiVatTu" => $item['loaiVatTu']['LoaiVatTu'],
                    "DonVi" => $item['donVi']['DonVi'],
                    "SoLuong" => $item['SoLuong'],
                ];
            }),
            "supplieOptions" => VatTu::query()->get()->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['TenVT'],
                ];
            }),
            "totalPage" => $supplies->total(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Supplies/New', [
            "kinds" => collect(LoaiVatTu::all())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['LoaiVatTu'],
                ];
            }),
            'units' => collect(DonViTinh::all())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['DonVi'],
                ];
            }),
        ]);
    }

    public function edit(int $id)
    {
        $record = VatTu::query()->findOrFail($id);

        return Inertia::render('Supplies/New', [
            "kinds" => collect(LoaiVatTu::all())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['LoaiVatTu'],
                ];
            }),
            'units' => collect(DonViTinh::all())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['DonVi'],
                ];
            }),
            "history" => NhapXuatVatTu::query()->get()->map(function ($item) {
                return array_merge($item->toArray(), [
                    'NgayBienDong' => Carbon::parse($item['NgayBienDong'])->format('d/m/Y')
                ]);
            }),
            "supplie" => $record->toArray()
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = VatTu::query()->findOrFail($id);

        $record->update($request->all());

        return redirect('/vat-tu');
    }

    public function store(Request $request)
    {
        VatTu::create($request->all());
        return redirect('/vat-tu');
    }

    public function destroy(int $id)
    {
        VatTu::destroy($id);

        return back();
    }

    public function pdfRemainingAmount()
    {
        $supplies = VatTu::with(['loaiVatTu', 'donVi', 'nhapxuat'])->when(request('f'), function ($q, $val) {
            $q->where('SoLuong', $val === 'het' ? '=' : '>', 0);
        })->get();
        $data = ["data" => collect($supplies)->map(function ($item) {
            return [
                "id" => $item['Id'],
                "TenVT" => $item['TenVT'],
                "LoaiVatTu" => $item['loaiVatTu']['LoaiVatTu'],
                "DonVi" => $item['donVi']['DonVi'],
                "SoLuongNhap" => $item['nhapxuat']->sum->SoLuongNhap,
                "SoLuongXuat" => $item['nhapxuat']->sum->SoLuongXuat,
                "SoLuongHienTai" => $item['SoLuong'],
            ];
        })];
        $pdf = PDF::loadView('vattu', $data);
        return $pdf->download('vattu.pdf');
    }

    public function import()
    {
        $vt = VatTu::query()->findOrFail(request('MaVatTu'));


        NhapXuatVatTu::query()->create([
            'MaVatTu' => request('MaVatTu'),
            'NgayBienDong' => request('NgayNhap'),
            'SoLuongNhap' => request('SoLuong'),
            'SoLuongHienTai' => $vt['SoLuong']
        ]);

        $vt->update([
            'SoLuong' => $vt['SoLuong'] + request('SoLuong')
        ]);

        return back();
    }
}
