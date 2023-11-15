<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use App\Models\NhanVien;
use App\Models\SoKhamBenh;
use App\Models\TienTrinhDieuTri;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class HealthRecordsController extends Controller
{
    public function index(): Response
    {
        $healthRecords = SoKhamBenh::query()->join('benhnhan', 'sokhambenh.MaBenhNhan', '=', 'benhnhan.id')->with(['bacSi'])->whereHas('benhNhan', function (Builder $q) {
            $q->where('HoVaTen', 'LIKE', '%' . request('q') . '%');
        })->orderBy('benhnhan.HoVaTen', request('sortType', 'asc'))->select(['HoVaTen', 'sokhambenh.Id as id', 'TrangThai', 'MaBacSi', 'ChanDoanBenh'])->paginate(10);

        return Inertia::render('HealthRecords/List', [
            "healthRecords" => collect($healthRecords->items())->map(function ($item) {
                return [
                    "id" => $item['id'],
                    "HoVaTen" => $item['HoVaTen'],
                    "BacSi" => $item['bacSi']['HoVaTen'],
                    "ChanDoanBenh" => $item['ChanDoanBenh'],
                    "TrangThai" => $item['TrangThai']
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

    public function changeStatus(int $id, Request $request)
    {
        $record = SoKhamBenh::query()->findOrFail($id);
        $record->update([
            'TrangThai' => $request['status']
        ]);

        return to_route('sokhambenh.show', $id);
    }

    public function show(int $id)
    {
        $record = SoKhamBenh::query()->with(['bacSi', 'benhNhan'])->findOrFail($id);
        $process = TienTrinhDieuTri::query()->with(['thuoc', 'vatTu'])->where('MaSoKhamBenh', $id)->paginate(10);
        return Inertia::render('HealthRecords/Detail', [
            "records" => [
                "id" => $record['Id'],
                "BenhNhan" => $record['benhNhan']['HoVaTen'],
                "BacSi" => $record['bacSi']['HoVaTen'],
                "ChanDoanBenh" => $record['ChanDoanBenh'],
                "TrangThai" => $record['TrangThai']
            ],
            "process" => collect($process->items())->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "Thuoc" => Arr::get($item, 'thuoc.TenThuoc'),
                    "VatTu" =>  Arr::get($item, 'vatTu.TenVT'),
                    'ChiTietDieuTri' => $item['ChiTietDieuTri'],
                    'Sothuoc' => $item['Sothuoc'],
                    'SoVatTu' => $item['SoVatTu'],
                    'TenTienTrinh' => $item['TenTienTrinh'],
                    'NgayDieuTri' => Carbon::parse($item['NgayDieuTri'])->format('d/m/Y'),
                ];
            }),
            "totalPage" => $process->total(),
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

    public function pdf(int $id)
    {
        $record = SoKhamBenh::query()->with(['bacSi', 'benhNhan'])->findOrFail($id);
        $process = TienTrinhDieuTri::query()->with(['thuoc', 'vatTu'])->where('MaSoKhamBenh', $id)->get();
        $data = [
            "records" => [
                "BenhNhan" => $record['benhNhan']['HoVaTen'],
                "BacSi" => $record['bacSi']['HoVaTen'],
                "ChanDoanBenh" => $record['ChanDoanBenh'],
                "TrangThai" => $record['TrangThai']
            ],
            "process" => collect($process)->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "Thuoc" => Arr::get($item, 'thuoc.TenThuoc'),
                    "VatTu" =>  Arr::get($item, 'vatTu.TenVT'),
                    'ChiTietDieuTri' => $item['ChiTietDieuTri'],
                    'NgayDieuTri' => Carbon::parse($item['NgayDieuTri'])->format('d/m/Y'),
                ];
            }),
        ];
        $pdf = PDF::loadView('sokhambenh', $data);
        return $pdf->download('sokhambenh.pdf');
    }

    public function pdfList()
    {
        $healthRecords = SoKhamBenh::query()->join('benhnhan', 'sokhambenh.MaBenhNhan', '=', 'benhnhan.id')->with(['bacSi'])->whereHas('benhNhan', function (Builder $q) {
            $q->where('HoVaTen', 'LIKE', '%' . request('q') . '%');
        })->orderBy('benhnhan.HoVaTen', request('sortType', 'asc'))->select(['HoVaTen', 'sokhambenh.Id as id', 'TrangThai', 'MaBacSi', 'ChanDoanBenh'])->paginate(10);
        $data = [
            "healthRecords" => $healthRecords->map(function ($item) {
                return [
                    "HoVaTen" => $item['HoVaTen'],
                    "BacSi" => $item['bacSi']['HoVaTen'],
                    "ChanDoanBenh" => $item['ChanDoanBenh'],
                    "TrangThai" => $item['TrangThai']
                ];
            }),
        ];
        $pdf = PDF::loadView('danhsachsokhambenh', $data);
        return $pdf->download('danhsachsokhambenh.pdf');
    }
}
