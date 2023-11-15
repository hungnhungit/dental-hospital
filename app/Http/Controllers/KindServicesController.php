<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoaiDichVu;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class KindServicesController extends Controller
{
    public function index(): Response
    {
        $kindService = LoaiDichVu::query()->where('XoaMem', 0)->paginate(10);

        return Inertia::render('KindServices/List', [
            "kindServices" => collect($kindService->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['LoaiDichVu'],
                ];
            }),
            "totalPage" => $kindService->total(),
        ]);
    }

    public function create()
    {
        return Inertia::render('KindServices/New');
    }

    public function edit(int $id)
    {
        $record = LoaiDichVu::query()->findOrFail($id);

        return Inertia::render('KindServices/New', [
            "kindService" => [
                "id" => $record['Id'],
                "name" => $record['LoaiDichVu'],
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = LoaiDichVu::query()->findOrFail($id);

        $checkDuplicate = LoaiDichVu::where('LoaiDichVu', $request['name'])->first();

        if ($checkDuplicate && $checkDuplicate['Id'] !== $record['Id']) {
            throw ValidationException::withMessages(['message' => "DUPLICATE"]);
        }

        $record->update([
            'LoaiDichVu' => $request['name'],
        ]);

        return redirect('/loai-dich-vu');
    }

    public function store(Request $request)
    {
        $checkDuplicate = LoaiDichVu::where('LoaiDichVu', $request['name'])->first();

        if ($checkDuplicate) {
            throw ValidationException::withMessages(['message' => "DUPLICATE"]);
        }

        LoaiDichVu::create([
            'LoaiDichVu' => $request['name'],
        ]);
        return redirect('/loai-dich-vu');
    }

    public function destroy(int $id)
    {
        LoaiDichVu::query()->findOrFail($id)->update(['XoaMem' => 1]);

        return back();
    }
}
