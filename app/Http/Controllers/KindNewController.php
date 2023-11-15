<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoaiTinTuc;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class KindNewController extends Controller
{
    public function index(): Response
    {
        $kindNew = LoaiTinTuc::query()->where('XoaMem', 0)->paginate(10);

        return Inertia::render('KindNew/List', [
            "kindNew" => collect($kindNew->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item['LoaiTinTuc'],
                ];
            }),
            "totalPage" => $kindNew->total(),
        ]);
    }

    public function create()
    {
        return Inertia::render('KindNew/New');
    }

    public function edit(int $id)
    {
        $record  = LoaiTinTuc::query()->findOrFail($id);
        return Inertia::render('KindNew/New', [
            'kindNew' => [
                "id" => $record['Id'],
                "name" => $record['LoaiTinTuc'],
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = LoaiTinTuc::query()->findOrFail($id);

        $checkDuplicate = LoaiTinTuc::where('LoaiTinTuc', $request['name'])->first();

        if ($checkDuplicate && $checkDuplicate['Id'] !== $record['Id']) {
            throw ValidationException::withMessages(['message' => "DUPLICATE"]);
        }

        $record->update([
            'LoaiTinTuc' => $request['name'],
        ]);

        return redirect('/loai-tin-tuc');
    }

    public function store(Request $request)
    {
        $checkDuplicate = LoaiTinTuc::where('LoaiTinTuc', $request['name'])->first();

        if ($checkDuplicate) {
            throw ValidationException::withMessages(['message' => "DUPLICATE"]);
        }

        LoaiTinTuc::create([
            'LoaiTinTuc' => $request['name'],
        ]);
        return redirect('/loai-tin-tuc');
    }

    public function destroy(int $id)
    {
        LoaiTinTuc::query()->findOrFail($id)->update(['XoaMem' => 1]);

        return back();
    }
}
