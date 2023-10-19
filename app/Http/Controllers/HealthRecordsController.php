<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use App\Models\NhanVien;
use App\Models\SoKhamBenh;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HealthRecordsController extends Controller
{
    public function index(): Response
    {
        $healthRecords = SoKhamBenh::with(['bacSi', 'benhNhan'])->paginate(10);
        return Inertia::render('HealthRecords/List', [
            "healthRecords" => collect($healthRecords->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "BenhNhan" => $item['benhNhan']['HoVaTen'],
                    "BacSi" => $item['bacSi']['HoVaTen'],
                    "ChanDoanBenh" => $item['ChanDoanBenh']
                ];
            }),
            "totalPage" => $healthRecords->total(),
        ]);
    }

    public function create()
    {
        return Inertia::render('HealthRecords/New', [
            'BacSi' => collect(NhanVien::query()->where('MaChucVu', 1)->get())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "name" => $item['HoVaTen']
                ];
            }),
            'BenhNhan' => collect(BenhNhan::all())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "name" => $item['HoVaTen']
                ];
            })
        ]);
    }

    public function edit(int $id)
    {
        $record = SoKhamBenh::query()->findOrFail($id);
        return Inertia::render('HealthRecords/New', [
            'BacSi' => collect(NhanVien::query()->where('MaChucVu', 1)->get())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "name" => $item['HoVaTen']
                ];
            }),
            'BenhNhan' => collect(BenhNhan::all())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "name" => $item['HoVaTen']
                ];
            }),
            "records" => $record->toArray()
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = SoKhamBenh::query()->findOrFail($id);
        $record->update($request->all());
        return redirect('/sokhambenh');
    }

    public function store(Request $request)
    {
        SoKhamBenh::create($request->all());
        return redirect('/sokhambenh');
    }

    public function destroy(int $id)
    {
        SoKhamBenh::destroy($id);

        return back();
    }
}
