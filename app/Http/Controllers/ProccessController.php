<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use App\Models\DichVu;
use App\Models\NhanVien;
use App\Models\SoKhamBenh;
use App\Models\Thuoc;
use App\Models\TienTrinhDieuTri;
use App\Models\TinhTrangBenh;
use App\Models\VatTu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProccessController extends Controller
{
    public function create(int $id)
    {
        return Inertia::render('Proccess/New', [
            "SoKhamBenhId" => $id,
            'DichVu' => DichVu::query()->get()->map(function ($item) {
                return [
                    'id' => $item['Id'],
                    'name' => $item['TenDichVu'],
                ];
            }),
            'Thuoc' => Thuoc::query()->get()->map(function ($item) {
                return [
                    'id' => $item['Id'],
                    'name' => $item['TenThuoc'],
                    'q' => $item['SoLuong']
                ];
            }),
            'VatTu' => VatTu::query()->get()->map(function ($item) {
                return [
                    'id' => $item['Id'],
                    'name' => $item['TenVT'],
                    'q' => $item['SoLuong']
                ];
            })
        ]);
    }

    public function edit(int $id, int $idT)
    {
        $process = TienTrinhDieuTri::query()->findOrFail($idT);

        return Inertia::render('Proccess/New', [
            "process" => $process->toArray(),
            "SoKhamBenhId" => $id,
            'DichVu' => DichVu::query()->get()->map(function ($item) {
                return [
                    'id' => $item['Id'],
                    'name' => $item['TenDichVu'],
                ];
            }),
            'Thuoc' => Thuoc::query()->get()->map(function ($item) {
                return [
                    'id' => $item['Id'],
                    'name' => $item['TenThuoc'],
                    'q' => $item['SoLuong']
                ];
            }),
            'VatTu' => VatTu::query()->get()->map(function ($item) {
                return [
                    'id' => $item['Id'],
                    'name' => $item['TenVT'],
                    'q' => $item['SoLuong']
                ];
            })
        ]);
    }

    public function store(int $id, Request $request)
    {

        TienTrinhDieuTri::create(array_merge($request->all(), ['MaSoKhamBenh' => $id]));
        return to_route('sokhambenh.show', $id);
    }

    public function update(int $id, int $idT, Request $request)
    {
        $process = TienTrinhDieuTri::query()->findOrFail($idT);
        $process->update($request->all());
        return to_route('sokhambenh.show', $id);
    }

    public function destroy(int $id)
    {
        TienTrinhDieuTri::destroy($id);

        return back();
    }
}
