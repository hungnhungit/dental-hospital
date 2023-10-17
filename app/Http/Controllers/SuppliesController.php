<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonViTinh;
use App\Models\LoaiVatTu;
use App\Models\VatTu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SuppliesController extends Controller
{
    public function index(): Response
    {
        $supplies = VatTu::with(['loaiVatTu', 'donVi'])->paginate(10);

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
}
