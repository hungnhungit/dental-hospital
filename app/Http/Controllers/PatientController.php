<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    public function index(): Response
    {
        $patients = BenhNhan::paginate(10);

        return Inertia::render('Patients/List', [
            "patients" => collect($patients->items())->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "full_name" => $item['HoVaTen'],
                    "dob" => $item['NgaySinh'],
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
        BenhNhan::destroy($id);

        return back();
    }
}
