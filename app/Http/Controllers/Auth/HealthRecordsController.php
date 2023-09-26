<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\News;
use App\Models\Patient;
use App\Models\SoKhamBenh;
use App\Models\TinTuc;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Role;

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
