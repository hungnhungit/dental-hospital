<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SoKhamBenh;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HealthRecordsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('HealthRecords/List');
    }

    public function paginate(Request $request)
    {
        $healthRecords = SoKhamBenh::with(['nguoiTao', 'bacSi', 'benhNhan', 'tinhTrang'])->paginate(10);

        return [
            "healthRecords" => collect($healthRecords->items())->map(function ($item) {
                return [
                    "patient" => $item['benhNhan']['HoVaTen'],
                    "doctor" => $item['bacSi']['HoVaTen'],
                    "created_by" => $item['nguoiTao']['HoVaTen'],
                    "sick" => $item['tinhTrang']['Ten'],
                ];
            }),
            "totalPage" => $healthRecords->total(),
        ];
    }
}
