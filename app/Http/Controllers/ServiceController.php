<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DichVu;
use App\Models\LoaiDichVu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(Request $request): Response
    {
        $services = DichVu::query()->with('loaiDichVu')->where('TenDichVu', 'LIKE', '%' . request('q') . '%')->orderBy('TenDichVu', $request['sortType'] ?? 'asc')->paginate(10);
        return Inertia::render('Services/List', [
            "services" => collect($services->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "TenDichVu" => $item['TenDichVu'],
                    "desc" => $item['MoTa'],
                    "price" => $item['Gia'],
                    'kindService' => $item['loaiDichVu']['LoaiDichVu']
                ];
            }),
            "totalPage" => $services->total(),
        ]);
    }

    public function create()
    {
        $kindService = LoaiDichVu::all();
        return Inertia::render('Services/New', [
            "kindService" => collect($kindService)->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item["LoaiDichVu"]
                ];
            })
        ]);
    }

    public function edit(int $id)
    {
        $record = DichVu::query()->findOrFail($id);
        $kindService = LoaiDichVu::all();
        return Inertia::render('Services/New', [
            "kindService" => collect($kindService)->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "name" => $item["LoaiDichVu"],
                ];
            }),
            "service" => [
                "id" => $record['Id'],
                'name' => $record['TenDichVu'],
                "desc" => $record['MoTa'],
                "price" => $record['Gia'],
                'kindService' => $record['LoaiDichVuId']
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = DichVu::query()->findOrFail($id);

        $record->update([
            'TenDichVu' => $request['name'],
            'MoTa' => $request['desc'],
            'Gia' => $request['price'],
            'LoaiDichVuId' => $request['kind'],
        ]);

        return redirect('/dichvu');
    }

    public function store(Request $request)
    {
        DichVu::create([
            'TenDichVu' => $request['name'],
            'MoTa' => $request['desc'],
            'Gia' => $request['price'],
            'LoaiDichVuId' => $request['kind'],
        ]);
        return redirect('/dichvu');
    }

    public function destroy(int $id)
    {
        DichVu::destroy($id);

        return back();
    }
}
