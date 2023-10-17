<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonViTinh;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UnitController extends Controller
{
    public function index(): Response
    {
        $units = DonViTinh::paginate(10);

        return Inertia::render('Unit/List', [
            "units" => collect($units->items())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "name" => $item['DonVi'],
                    "calc" => $item['HeSo']
                ];
            }),
            "totalPage" => $units->total(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Unit/New');
    }

    public function edit(int $id)
    {
        $record = DonViTinh::query()->findOrFail($id);

        return Inertia::render('Unit/New', [
            "unit" => [
                "id" => $record["Id"],
                "name" => $record['DonVi'],
                "float" => $record['HeSo']
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = DonViTinh::query()->findOrFail($id);

        $record->update([
            'DonVi' => $request['name'],
            'HeSo' => $request['float']
        ]);

        return redirect('/donvitinh');
    }

    public function store(Request $request)
    {
        DonViTinh::create([
            'DonVi' => $request['name'],
            'HeSo' => $request['float']
        ]);
        return redirect('/donvitinh');
    }

    public function destroy(int $id)
    {
        DonViTinh::destroy($id);

        return back();
    }
}
