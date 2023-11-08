<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonViTinh;
use App\Models\LoaiThuoc;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class KindMedicineController extends Controller
{
    public function index(): Response
    {
        $kindMedicine = LoaiThuoc::paginate(10);
        return Inertia::render('KindMedicine/List', [
            "kindMedicine" => collect($kindMedicine->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['LoaiThuoc'],
                ];
            }),
            "totalPage" => $kindMedicine->total(),
        ]);
    }

    public function create()
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
                "id" => $record['Id'],
                "name" => $record['LoaiThuoc'],
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = LoaiThuoc::query()->findOrFail($id);

        $checkDuplicate = LoaiThuoc::where('LoaiThuoc', $request['name'])->first();

        if ($checkDuplicate && $checkDuplicate['Id'] !== $record['Id']) {
            throw ValidationException::withMessages(['message' => "DUPLICATE"]);
        }

        $record->update([
            'LoaiThuoc' => $request['name'],
        ]);

        return redirect('/loai-thuoc');
    }

    public function store(Request $request)
    {
        $checkDuplicate = LoaiThuoc::where('LoaiThuoc', $request['name'])->first();

        if ($checkDuplicate) {
            throw ValidationException::withMessages(['message' => "DUPLICATE"]);
        }

        LoaiThuoc::create([
            'LoaiThuoc' => $request['name'],
        ]);
        return redirect('/loai-thuoc');
    }

    public function destroy(int $id)
    {
        LoaiThuoc::destroy($id);

        return back();
    }
}
