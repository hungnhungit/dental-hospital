<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Patients/List');
    }

    public function paginate(Request $request)
    {
        $patients = BenhNhan::paginate(10);

        return [
            "patients" => collect($patients->items())->map(function ($item) {
                return [
                    "full_name" => $item['HoVaTen'],
                    "dob" => $item['NgaySinh'],
                    "phone" => $item['DienThoai'],
                    "address" => $item['DiaChi'],
                    "cccd" => $item['cccd']
                ];
            }),
            "totalPage" => $patients->total(),
        ];
    }
}
