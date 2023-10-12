<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoaiTinTuc;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class KindNewController extends Controller
{
    public function index(): Response
    {
        $kindNew = LoaiTinTuc::paginate(10);

        return Inertia::render('KindNew/List', [
            "kindNew" => collect($kindNew->items())->map(function ($item) {
                return [
                    "id" => $item['idLTT'],
                    "name" => $item['Ten'],
                    "slug" => $item['DuongDan']
                ];
            }),
            "totalPage" => $kindNew->total(),
        ]);
    }

    public function new()
    {
        return Inertia::render('KindNew/New');
    }

    public function edit(int $id)
    {
        $record  = LoaiTinTuc::query()->findOrFail($id);
        return Inertia::render('KindNew/New', [
            'kindNew' => [
                "id" => $record['idLTT'],
                "name" => $record['Ten'],
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = LoaiTinTuc::query()->findOrFail($id);

        $record->update([
            'Ten' => $request['name'],
            'DuongDan' => Str::slug($request['name']),
        ]);

        return redirect('/loai-tin-tuc');
    }

    public function store(Request $request)
    {
        LoaiTinTuc::create([
            'Ten' => $request['name'],
            'DuongDan' => Str::slug($request['name']),
        ]);
        return redirect('/loai-tin-tuc');
    }

    public function destroy(Request $request)
    {
        LoaiTinTuc::destroy($request['id']);

        return redirect('/loai-tin-tuc');
    }
}
