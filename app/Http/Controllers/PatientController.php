<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use PDF;

class PatientController extends Controller
{
    public function index(Request $request): Response
    {
        $patients = BenhNhan::query()->where('XoaMem', 0)->where('HoVaTen', 'LIKE', '%' . request('q') . '%')->orderBy($request['sortCols'] ?? 'HoVaTen', $request['sortType'] ?? 'asc')->paginate(10);

        return Inertia::render('Patients/List', [
            "patients" => collect($patients->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "HoVaTen" => $item['HoVaTen'],
                    "TongTienChi" => $item['TongTienChi'],
                    "dob" => Carbon::parse($item['NgaySinh'])->format('d/m/Y'),
                    "phone" => $item['DienThoai'],
                    "address" => $item['DiaChi'],
                    "cccd" => $item['CMND'],
                    "h" => $item['ChieuCao'],
                    "w" => $item['CanNang'],
                    "blood" => $item['NhomMau'],
                ];
            }),
            "totalPage" => $patients->total(),
        ]);
    }

    public function edit(int $id)
    {
        $record = BenhNhan::query()->findOrFail($id);
        return Inertia::render('Patients/New', [
            "patient" => $record->toArray()
        ]);
    }

    public function create()
    {
        return Inertia::render('Patients/New');
    }

    public function update(int $id, Request $request)
    {
        $record = BenhNhan::query()->findOrFail($id);

        $record->update($request->all());

        return redirect('/benhnhan');
    }

    public function store(Request $request)
    {
        BenhNhan::create($request->all());
        return redirect('/benhnhan');
    }

    public function destroy(int $id)
    {
        BenhNhan::query()->findOrFail($id)->update([
            'XoaMem' => '1'
        ]);

        return back();
    }

    public function pdf()
    {
        $patients = BenhNhan::query()->where('XoaMem', 0)->where('HoVaTen', 'LIKE', '%' . request('q') . '%')->orderBy('HoVaTen', $request['sortType'] ?? 'asc')->get();
        $data = ["patients" => $patients->map(function ($item) {
            return [
                "HoVaTen" => $item['HoVaTen'],
                "NgaySinh" => $item['NgaySinh'],
                "DienThoai" => $item['DienThoai'],
                "DiaChi" => $item['DiaChi'],
                "CMND" => $item['CMND'],
                "ChieuCao" => $item['ChieuCao'],
                "CanNang" => $item['CanNang'],
                "NhomMau" => $item['NhomMau'],
            ];
        })];
        $pdf = PDF::loadView('benhnhan', $data);
        return $pdf->download('benhnhan.pdf');
    }
}
