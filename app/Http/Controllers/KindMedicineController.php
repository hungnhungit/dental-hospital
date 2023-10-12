<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonViTinh;
use App\Models\LoaiThuoc;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KindMedicineController extends Controller
{
    public function index(): Response
    {
        $kindMedicine = LoaiThuoc::with('donViTinh')->paginate(10);
        return Inertia::render('KindMedicine/List', [
            "kindMedicine" => collect($kindMedicine->items())->map(function ($item) {
                return [
                    "id" => $item['idLoaithuoc'],
                    "name" => $item['TenLT'],
                    "desc" => $item['Mota'],
                    "unit" => $item['donViTinh']['TenDVT'],
                ];
            }),
            "totalPage" => $kindMedicine->total(),
        ]);
    }

    public function new()
    {
        return Inertia::render('KindMedicine/New', [
            'units' => DonViTinh::all(),
        ]);
    }

    public function edit(int $id)
    {
        $record  = LoaiThuoc::query()->findOrFail($id);
        return Inertia::render('KindMedicine/New', [
            'units' => DonViTinh::all(),
            'kindMedicine' => [
                "id" => $record['idLoaithuoc'],
                "name" => $record['TenLT'],
                "desc" => $record['Mota'],
                "unit" => $record['idDonvitinh']
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = LoaiThuoc::query()->findOrFail($id);

        $record->update([
            'TenLT' => $request['name'],
            'Mota' => $request['desc'],
            'idDonvitinh' => $request['unit']
        ]);

        return redirect('/loai-thuoc');
    }

    public function store(Request $request)
    {
        LoaiThuoc::create([
            'TenLT' => $request['name'],
            'Mota' => $request['desc'],
            'idDonvitinh' => $request['unit']
        ]);
        return redirect('/loai-thuoc');
    }

    public function destroy(Request $request)
    {
        LoaiThuoc::destroy($request['id']);

        return redirect('/loai-thuoc');
    }
}
