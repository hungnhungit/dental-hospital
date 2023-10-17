<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonViTinh;
use App\Models\LoaiThuoc;
use App\Models\Thuoc;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MedicineController extends Controller
{
    public function index(): Response
    {
        $medicines = Thuoc::with(['loaiThuoc', 'donVi'])->paginate(10);
        return Inertia::render('Medicine/List', [
            "medicines" => collect($medicines->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "Ten" => $item['TenThuoc'],
                    "LoaiThuoc" => $item['loaiThuoc']['LoaiThuoc'],
                    "DonVi" => $item['donVi']['DonVi'],
                    "CongDung" => $item['CongDung'],
                    "CachDung" => $item['CachDung'],
                    "SoLuong" => $item['SoLuong'],
                    "HSD" => $item['HSD'],
                ];
            }),
            "totalPage" => $medicines->total(),
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
            "medicine" => $record->toArray()
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
}
