<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Thuoc;
use App\Models\TienTrinhDieuTri;
use App\Models\VatTu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

use function PHPUnit\Framework\isNull;

class ProccessController extends Controller
{
    public function index()
    {
        $proccess = TienTrinhDieuTri::query()->when(request('start'), function ($q) {
            $q->whereBetween('NgayDieuTri', [request('start'), request('end')]);
        })->orderBy('NgayDieuTri', 'desc')->with(['sokham' => function ($q) {
            $q->with(['bacSi', 'benhNhan']);
        }])->paginate(10);

        return Inertia::render('Proccess/List', [
            "proccess" => collect($proccess->items())->map(function ($item) {
                return [
                    "TenTienTrinh" => $item['TenTienTrinh'],
                    "TenBacSi" => Arr::get($item, 'sokham.bacSi.HoVaTen', ''),
                    "TenBenhNhan" => Arr::get($item, 'sokham.benhNhan.HoVaTen', ''),
                    "ChiTietDieuTri" => $item['ChiTietDieuTri'],
                    "NgayDieuTri" =>  Carbon::parse($item['NgayDieuTri'])->format('d/m/Y'),
                ];
            }),
            "totalPage" => $proccess->total(),
        ]);
    }
    public function create(int $id)
    {
        return Inertia::render('Proccess/New', [
            "SoKhamBenhId" => $id,
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
            "process" => array_merge($process->toArray(), [
                'LinkHinhAnh' =>  $process['HinhAnhXetNghiem'] ? asset('storage/' . $process['HinhAnhXetNghiem']) : null
            ]),
            "SoKhamBenhId" => $id,
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
        if (!is_null($request['MaThuoc'])) {
            $thuoc = Thuoc::query()->findOrFail($request['MaThuoc']);
            if ($thuoc['SoLuong'] < $request['Sothuoc']) {
                throw ValidationException::withMessages(['message' => 'QUANTITY_LIMIT_MEDICINE']);
            }

            $thuoc->update([
                'SoLuong' => $thuoc['SoLuong'] - $request['Sothuoc']
            ]);
        }

        if (!is_null($request['MaVatTu'])) {
            $vattu = VatTu::query()->findOrFail($request['MaVatTu']);
            if ($vattu['SoLuong'] < $request['SoVatTu']) {
                throw  ValidationException::withMessages(['message' => 'QUANTITY_LIMIT_SUPPLIES']);
            }

            $vattu->update([
                'SoLuong' => $vattu['SoLuong'] - $request['SoVatTu']
            ]);
        }

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
