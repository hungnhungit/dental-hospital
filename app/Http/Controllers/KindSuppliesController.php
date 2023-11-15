<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoaiVatTu;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class KindSuppliesController extends Controller
{
    public function index(): Response
    {
        $supplies = LoaiVatTu::query()->where('XoaMem', 0)->paginate(10);

        return Inertia::render('KindSupplies/List', [
            "supplies" => collect($supplies->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['LoaiVatTu'],
                ];
            }),
            "totalPage" => $supplies->total(),
        ]);
    }

    public function create()
    {
        return Inertia::render('KindSupplies/New');
    }

    public function edit(int $id)
    {
        $record = LoaiVatTu::query()->findOrFail($id);

        return Inertia::render('KindSupplies/New', [
            "kindSupplies" => [
                "id" => $record['Id'],
                "name" => $record['LoaiVatTu'],
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = LoaiVatTu::query()->findOrFail($id);

        $checkDuplicate = LoaiVatTu::where('LoaiVatTu', $request['name'])->first();

        if ($checkDuplicate && $checkDuplicate['Id'] !== $record['Id']) {
            throw ValidationException::withMessages(['message' => "DUPLICATE"]);
        }

        $record->update([
            'LoaiVatTu' => $request['name'],
        ]);

        return redirect('/loai-vat-tu');
    }

    public function store(Request $request)
    {
        $checkDuplicate = LoaiVatTu::where('LoaiVatTu', $request['name'])->first();

        if ($checkDuplicate) {
            throw ValidationException::withMessages(['message' => "DUPLICATE"]);
        }

        LoaiVatTu::create([
            'LoaiVatTu' => $request['name'],
        ]);
        return redirect('/loai-vat-tu');
    }

    public function destroy(int $id)
    {
        LoaiVatTu::query()->findOrFail($id)->update(['XoaMem' => 1]);

        return back();
    }
}
